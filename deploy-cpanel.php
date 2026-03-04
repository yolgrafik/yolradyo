<?php
/**
 * cPanel FTP Deployment Script
 * 
 * Bu script, projeyi public_html'e yüklenecek "düz" (flat) yapıda hazırlar.
 * cPanel'de document root public_html ise bu yapıyı kullanın.
 * 
 * Kullanım: php deploy-cpanel.php
 * Çıktı: deploy-cpanel/ klasörü (bunu FTP ile public_html'e yükleyin)
 */

$root = __DIR__;
$out = $root . '/deploy-cpanel';

// Temizle ve oluştur
if (is_dir($out)) {
    echo "Mevcut deploy-cpanel siliniyor...\n";
    rmdirRecursive($out);
}
mkdir($out, 0755, true);

$dirs = [
    'app', 'bootstrap', 'config', 'database', 'public', 'resources', 'routes', 'storage', 'vendor'
];

foreach ($dirs as $dir) {
    $src = $root . '/' . $dir;
    if (!is_dir($src) && $dir !== 'storage') {
        echo "UYARI: $dir bulunamadı, atlanıyor.\n";
        continue;
    }
    if ($dir === 'public') {
        // public/ içeriğini deploy köküne kopyala (index.php ve .htaccess hariç - sonra özel yazılacak)
        $pubFiles = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($src, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($pubFiles as $item) {
            $subPath = str_replace($src . DIRECTORY_SEPARATOR, '', $item->getPathname());
            $subPath = str_replace('\\', '/', $subPath);
            if (in_array($subPath, ['index.php', '.htaccess']) || $subPath === '.gitignore') continue;
            $target = $out . '/' . $subPath;
            if ($item->isDir()) {
                if (!is_dir($target)) mkdir($target, 0755, true);
            } else {
                $targetDir = dirname($target);
                if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
                copy($item->getPathname(), $target);
            }
        }
    } elseif ($dir === 'storage') {
        mkdir($out . '/storage', 0755, true);
        $storageSub = ['app', 'framework', 'logs'];
        foreach ($storageSub as $s) {
            $p = $out . '/storage/' . $s;
            mkdir($p, 0755, true);
            if ($s === 'framework') {
                mkdir($p . '/cache', 0755, true);
                mkdir($p . '/cache/data', 0755, true);
                mkdir($p . '/sessions', 0755, true);
                mkdir($p . '/views', 0755, true);
                file_put_contents($p . '/cache/.gitignore', "*\n!.gitignore\n");
                file_put_contents($p . '/cache/data/.gitignore', "*\n!.gitignore\n");
                file_put_contents($p . '/sessions/.gitignore', "*\n!.gitignore\n");
                file_put_contents($p . '/views/.gitignore', "*\n!.gitignore\n");
            }
            if ($s === 'app') {
                mkdir($p . '/public', 0755, true);
                file_put_contents($p . '/.gitignore', "*\n!.gitignore\n");
            }
        }
    } elseif ($dir === 'bootstrap') {
        copyDirExclude($src, $out . '/' . $dir, ['.git', 'node_modules', '.env']);
        if (!is_dir($out . '/bootstrap/cache')) mkdir($out . '/bootstrap/cache', 0755, true);
        file_put_contents($out . '/bootstrap/cache/.gitignore', "*\n!.gitignore\n");
    } else {
        copyDirExclude($src, $out . '/' . $dir, ['.git', 'node_modules', '.env']);
    }
}

// index.php - FLAT yapı için (public_html kökünde her şey)
$indexContent = <<<'PHP'
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// cPanel flat yapı: vendor, bootstrap, storage aynı dizinde (public_html)
$basePath = __DIR__;

if (file_exists($maintenance = $basePath . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $basePath . '/vendor/autoload.php';

/** @var Application $app */
$app = require_once $basePath . '/bootstrap/app.php';

$app->handleRequest(Request::capture());
PHP;

file_put_contents($out . '/index.php', $indexContent);

// .htaccess - public'ten kopyala
copy($root . '/public/.htaccess', $out . '/.htaccess');

// .env.example
copy($root . '/.env.example', $out . '/.env.example');

// artisan, composer.json, composer.lock
foreach (['artisan', 'composer.json', 'composer.lock'] as $f) {
    if (file_exists($root . '/' . $f)) {
        copy($root . '/' . $f, $out . '/' . $f);
    }
}

echo "\n✓ deploy-cpanel/ hazır!\n";
echo "FTP ile deploy-cpanel/ içeriğini public_html/ klasörüne yükleyin.\n";
echo "Sonra sunucuda: cp .env.example .env && php artisan key:generate\n";

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
