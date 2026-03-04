<?php
/**
 * cPanel FTP Deployment Script
 *
 * Document root public_html olan cPanel hostlar için.
 * Backend (app, vendor, vb.) yolcu/ altında, public içerik kökte.
 *
 * Kullanım: php deploy-cpanel.php
 * Çıktı: deploy-cpanel/ → FTP ile public_html'e yükleyin
 */

$root = __DIR__;
$out = $root . '/release';  // FTP ile public_html'e yüklenecek paket
$backend = 'yolcu';

if (is_dir($out)) {
    echo "Mevcut release siliniyor...\n";
    rmdirRecursive($out);
}
mkdir($out, 0755, true);
mkdir($out . '/' . $backend, 0755, true);

// 1. public/ içeriğini deploy köküne (index.php, .htaccess hariç)
$pubSrc = $root . '/public';
$pubIter = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($pubSrc, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);
foreach ($pubIter as $item) {
    $subPath = str_replace($pubSrc . DIRECTORY_SEPARATOR, '', $item->getPathname());
    $subPath = str_replace('\\', '/', $subPath);
    if (in_array($subPath, ['index.php', '.htaccess']) || $subPath === '.gitignore') continue;
    $target = $out . '/' . $subPath;
if ($item->isDir()) {
                if (!is_dir($target)) mkdir($target, 0755, true);
            } elseif ($item->isFile()) {
                $targetDir = dirname($target);
                if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
                copy($item->getPathname(), $target);
            }
}

// 2. Backend klasörlerini yolcu/ altına kopyala
$backendDirs = ['app', 'bootstrap', 'config', 'database', 'resources', 'routes', 'storage', 'vendor'];
foreach ($backendDirs as $dir) {
    $src = $root . '/' . $dir;
    if (!is_dir($src) && $dir !== 'storage') {
        echo "UYARI: $dir bulunamadı.\n";
        continue;
    }
    if ($dir === 'storage') {
        mkdir($out . '/' . $backend . '/storage', 0755, true);
        foreach (['app', 'app/public', 'framework', 'framework/cache', 'framework/cache/data', 'framework/sessions', 'framework/views', 'logs'] as $s) {
            $p = $out . '/' . $backend . '/storage/' . $s;
            if (!is_dir($p)) mkdir($p, 0755, true);
        }
        foreach (['storage/framework/cache', 'storage/framework/cache/data', 'storage/framework/sessions', 'storage/framework/views', 'storage/app'] as $g) {
            $gitignorePath = $out . '/' . $backend . '/' . $g . '/.gitignore';
            $gitignoreDir = dirname($gitignorePath);
            if (!is_dir($gitignoreDir)) mkdir($gitignoreDir, 0755, true);
            file_put_contents($gitignorePath, "*\n!.gitignore\n");
        }
    } elseif ($dir === 'bootstrap') {
        copyDirExclude($src, $out . '/' . $backend . '/' . $dir, ['.git', 'node_modules', '.env']);
        $cacheDir = $out . '/' . $backend . '/bootstrap/cache';
        if (!is_dir($cacheDir)) mkdir($cacheDir, 0755, true);
        file_put_contents($cacheDir . '/.gitignore', "*\n!.gitignore\n");
        // cPanel: public path = parent of backend (document root)
        $bootstrapApp = file_get_contents($out . '/' . $backend . '/bootstrap/app.php');
        $bootstrapApp = str_replace('return Application::configure', '$app = Application::configure', $bootstrapApp);
        $bootstrapApp = str_replace(')->create();', ')->create();' . "\n" . '$app->usePublicPath(dirname($app->basePath()));' . "\n" . 'return $app;', $bootstrapApp);
        file_put_contents($out . '/' . $backend . '/bootstrap/app.php', $bootstrapApp);
    } else {
        copyDirExclude($src, $out . '/' . $backend . '/' . $dir, ['.git', 'node_modules', '.env']);
    }
}

// 3. index.php - public_html kökünde, backend yolcu/ altında
$indexContent = <<<PHP
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

\$backendDir = __DIR__ . '/{$backend}';
\$maintenance = \$backendDir . '/storage/framework/maintenance.php';

if (file_exists(\$maintenance)) {
    require \$maintenance;
}

require \$backendDir . '/vendor/autoload.php';

/** @var Application \$app */
\$app = require_once \$backendDir . '/bootstrap/app.php';

\$app->handleRequest(Request::capture());
PHP;

file_put_contents($out . '/index.php', $indexContent);

// 4. .htaccess
copy($root . '/public/.htaccess', $out . '/.htaccess');

// 5. artisan, composer, .env.example
copy($root . '/.env.example', $out . '/' . $backend . '/.env.example');
foreach (['artisan', 'composer.json', 'composer.lock'] as $f) {
    if (file_exists($root . '/' . $f)) {
        copy($root . '/' . $f, $out . '/' . $backend . '/' . $f);
    }
}

// 6. yolcu/.htaccess - Doğrudan web erişimini engelle (.env, config koruması)
$yolcuHtaccess = <<<'HTA'
# Backend klasörüne doğrudan HTTP erişimini engelle
# Sadece index.php üzerinden bootstrap edilir
<IfModule mod_authz_core.c>
    Require all denied
</IfModule>
<IfModule !mod_authz_core.c>
    Order deny,allow
    Deny from all
</IfModule>
HTA;
file_put_contents($out . '/' . $backend . '/.htaccess', $yolcuHtaccess);

// 7. Kök .user.ini (cPanel PHP ayarları - opsiyonel)
$userIni = "upload_max_filesize = 32M\npost_max_size = 32M\nmax_execution_time = 120\nmemory_limit = 256M";
file_put_contents($out . '/.user.ini', $userIni);

// 8. KURULUM.txt
$kurulum = <<<'TXT'
CPANEL / FTP KURULUM
===================

1. FTP ile bu klasörün İÇERİĞİNİ public_html'e yükleyin.
   (index.php, .htaccess, assets, build, uploads, yolcu hepsi public_html'de olmalı)

2. cPanel > Terminal veya SSH:
   cd ~/public_html/yolcu
   cp .env.example .env
   php artisan key:generate

3. .env düzenleyin (APP_URL, DB_*, APP_ENV=production, APP_DEBUG=false)

4. Devam:
   php artisan storage:link
   php artisan migrate --force
   chmod -R 775 storage bootstrap/cache

5. Tarayıcıda siteyi açın.
TXT;
file_put_contents($out . '/KURULUM.txt', $kurulum);

echo "\n✓ release/ hazır!\n";
echo "FTP ile release/ İÇERİĞİNİ public_html/ klasörüne yükleyin.\n";
echo "(release içindeki tüm dosya ve klasörler public_html'e gelsin)\n\n";
echo "Sunucuda (SSH veya cPanel Terminal):\n";
echo "  cd ~/public_html/{$backend}\n";
echo "  cp .env.example .env\n";
echo "  php artisan key:generate\n";
echo "  php artisan storage:link\n";
echo "  php artisan migrate --force\n";
echo "  chmod -R 775 storage bootstrap/cache\n";

function copyDirExclude($src, $dest, $exclude = []) {
    if (!is_dir($dest)) mkdir($dest, 0755, true);
    $iter = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($src, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    foreach ($iter as $item) {
        $subPath = $iter->getSubPathname();
        $subPathNorm = str_replace('\\', '/', $subPath);
        $parts = explode('/', $subPathNorm);
        $skip = false;
        foreach ($exclude as $ex) {
            if (in_array($ex, $parts) || $subPathNorm === $ex) { $skip = true; break; }
        }
        if ($skip) continue;
        $target = $dest . '/' . $subPath;
        if ($item->isDir()) {
            if (!is_dir($target)) mkdir($target, 0755, true);
        } else {
            copy($item->getPathname(), $target);
        }
    }
}

function rmdirRecursive($dir) {
    foreach (new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    ) as $path) {
        $path->isDir() ? rmdir($path) : unlink($path);
    }
    rmdir($dir);
}
