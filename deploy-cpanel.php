<?php
/**
 * cPanel KAYIPSIZ RELEASE Paketi
 *
 * Sonuç: release/ içinde 3 ayrı klasör - bunları ayrı yerlere atacaksınız.
 * Manuel taşıma/düzenleme YOK. Sadece FTP ile doğru yere yükle.
 *
 * Kullanım: php deploy-cpanel.php
 * Çıktı: release/
 *   ├── backend/      -> public_html DIŞINA (home/backend)
 *   ├── public_html/  -> public_html İÇİNE (içeriğini at)
 *   ├── sql/          -> full-export.sql (phpMyAdmin import)
 *   └── KURULUM.txt
 */

$root = __DIR__;
$out = $root . '/release';

echo "=== KAYIPSIZ cPanel RELEASE Paketi ===\n\n";

if (is_dir($out)) {
    echo "Mevcut release siliniyor...\n";
    rmdirRecursive($out);
}

mkdir($out, 0755, true);
mkdir($out . '/backend', 0755, true);
mkdir($out . '/public_html', 0755, true);
mkdir($out . '/sql', 0755, true);

// ========== 1. PUBLIC_HTML (sadece yayın kökü) ==========
$pubSrc = $root . '/public';
$pubOut = $out . '/public_html';
$pubIter = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($pubSrc, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);
$skipPub = ['.gitignore'];
foreach ($pubIter as $item) {
    $subPath = str_replace($pubSrc . DIRECTORY_SEPARATOR, '', $item->getPathname());
    $subPath = str_replace('\\', '/', $subPath);
    if (basename($subPath) === '.gitignore' && strpos($subPath, '/') === false) continue;
    if ($subPath === 'storage' && $item->isDir()) continue;
    $target = $pubOut . '/' . $subPath;
    if ($item->isDir()) {
        if (!is_dir($target)) mkdir($target, 0755, true);
    } else {
        $targetDir = dirname($target);
        if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
        copy($item->getPathname(), $target);
    }
}

// public_html/index.php - ../backend referansı
$indexContent = <<<'PHP'
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$backendDir = dirname(__DIR__) . '/backend';
$maintenance = $backendDir . '/storage/framework/maintenance.php';

if (file_exists($maintenance)) {
    require $maintenance;
}

require $backendDir . '/vendor/autoload.php';

/** @var Application $app */
$app = require_once $backendDir . '/bootstrap/app.php';

$app->handleRequest(Request::capture());
PHP;
file_put_contents($pubOut . '/index.php', $indexContent);

// public_html/.htaccess
copy($root . '/public/.htaccess', $pubOut . '/.htaccess');

// public_html/.user.ini
$userIni = <<<'INI'
; cPanel PHP - production
upload_max_filesize = 128M
post_max_size = 128M
max_execution_time = 180
memory_limit = 256M
default_charset = "UTF-8"
INI;
file_put_contents($pubOut . '/.user.ini', $userIni);

echo "  [OK] public_html/ hazir (index.php, .htaccess, assets, uploads)\n";

// ========== 2. BACKEND (public_html dışı) ==========
$backendDirs = ['app', 'bootstrap', 'config', 'database', 'resources', 'routes', 'storage', 'vendor'];
foreach ($backendDirs as $dir) {
    $src = $root . '/' . $dir;
    if (!is_dir($src)) {
        if ($dir === 'storage') {
            foreach (['app', 'app/public', 'framework', 'framework/cache', 'framework/cache/data', 'framework/sessions', 'framework/views', 'logs'] as $s) {
                mkdir($out . '/backend/storage/' . $s, 0755, true);
            }
        }
        continue;
    }
    if ($dir === 'storage') {
        $storageDirs = ['app', 'app/public', 'framework', 'framework/cache', 'framework/cache/data', 'framework/sessions', 'framework/views', 'logs'];
        foreach ($storageDirs as $s) {
            $p = $out . '/backend/storage/' . $s;
            if (!is_dir($p)) mkdir($p, 0755, true);
        }
        copyDirContents($root . '/storage/app/public', $out . '/backend/storage/app/public');
        foreach (['framework/cache', 'framework/cache/data', 'framework/sessions', 'framework/views', 'app'] as $g) {
            $gp = $out . '/backend/storage/' . $g . '/.gitignore';
            if (!is_dir(dirname($gp))) mkdir(dirname($gp), 0755, true);
            file_put_contents($gp, "*\n!.gitignore\n");
        }
    } elseif ($dir === 'bootstrap') {
        copyDirExclude($src, $out . '/backend/bootstrap', ['.git', 'node_modules', '.env']);
        $cacheDir = $out . '/backend/bootstrap/cache';
        if (!is_dir($cacheDir)) mkdir($cacheDir, 0755, true);
        file_put_contents($cacheDir . '/.gitignore', "*\n!.gitignore\n");
        $bootstrapApp = file_get_contents($out . '/backend/bootstrap/app.php');
        $bootstrapApp = str_replace('return Application::configure', '$app = Application::configure', $bootstrapApp);
        $bootstrapApp = str_replace(')->create();', ')->create();' . "\n" . '$_pub = realpath($app->basePath() . \'/../public_html\'); if ($_pub) { $app->usePublicPath($_pub); }' . "\n" . 'return $app;', $bootstrapApp);
        file_put_contents($out . '/backend/bootstrap/app.php', $bootstrapApp);
    } else {
        copyDirExclude($src, $out . '/backend/' . $dir, ['.git', 'node_modules', '.env']);
    }
}

foreach (['artisan', 'composer.json', 'composer.lock'] as $f) {
    if (file_exists($root . '/' . $f)) {
        copy($root . '/' . $f, $out . '/backend/' . $f);
    }
}

copy($root . '/.env.example', $out . '/backend/.env.example');
copy($root . '/.env.example', $out . '/backend/.env.production.example');

$envProd = file_get_contents($out . '/backend/.env.production.example');
$envProd = preg_replace('/^APP_URL=.*/m', 'APP_URL=https://siteniz.com', $envProd);
$envProd = "# Production icin .env olusturun: cp .env.production.example .env\n# Sonra DB_* ve APP_URL duzenleyin.\n\n" . $envProd;
file_put_contents($out . '/backend/.env.production.example', $envProd);

echo "  [OK] backend/ hazir (app, vendor, storage - public_html disinda)\n";

// ========== 3. SQL ==========
$sqlFile = $out . '/sql/full-export.sql';
$sqlDone = false;
if (file_exists($root . '/.env')) {
    $prevCwd = getcwd();
    chdir($root);
    exec('php artisan db:export --output=database/full-export.sql 2>&1', $artisanOut, $artisanRet);
    chdir($prevCwd);
    if ($artisanRet === 0 && file_exists($root . '/database/full-export.sql')) {
        copy($root . '/database/full-export.sql', $sqlFile);
        $sqlDone = true;
        echo "  [OK] sql/full-export.sql (artisan db:export)\n";
    }
}
if (!$sqlDone) {
    $env = parseEnv($root . '/.env');
    $dbName = $env['DB_DATABASE'] ?? '';
    $dbUser = $env['DB_USERNAME'] ?? '';
    $dbPass = $env['DB_PASSWORD'] ?? '';
    $dbHost = $env['DB_HOST'] ?? '127.0.0.1';
    if ($dbName && $dbUser) {
        $mysqldump = getMysqldumpPath();
        if ($mysqldump) {
            $cmd = sprintf('%s -h %s -u %s %s %s --single-transaction --routines --triggers --set-charset 2>nul',
                escapeshellcmd($mysqldump), escapeshellarg($dbHost), escapeshellarg($dbUser),
                $dbPass ? '-p' . escapeshellarg($dbPass) . ' ' : '', escapeshellarg($dbName));
            $output = shell_exec($cmd);
            if ($output && strlen(trim($output)) > 100) {
                file_put_contents($sqlFile, $output);
                $sqlDone = true;
                echo "  [OK] sql/full-export.sql (mysqldump)\n";
            }
        }
    }
}
if (!$sqlDone && file_exists($root . '/database/schema.sql')) {
    copy($root . '/database/schema.sql', $sqlFile);
    echo "  [OK] sql/full-export.sql (schema.sql kopyalandi)\n";
} elseif (!$sqlDone) {
    echo "  [!!] SQL export basarisiz. Manuel: php artisan db:export\n";
}

// ========== 4. KURULUM.txt ==========
$kurulum = <<<'TXT'
================================================================================
  cPanel KAYIPSIZ KURULUM - 5 ADIM
================================================================================

Yapı: backend public_html DIŞINDA. public_html sadece yayın kökü.

--------------------------------------------------------------------------------
ADIM 1: FTP ile backend/ klasörünü public_html DIŞINA yükleyin
--------------------------------------------------------------------------------
Hedef: /home/KULLANICI_ADI/backend/
(cPanel File Manager: Ana dizinde "backend" klasörü oluşturup içine atın)

İçinde olmalı: app, bootstrap, config, database, resources, routes, storage, vendor,
               artisan, composer.json, .env.example, .env.production.example


--------------------------------------------------------------------------------
ADIM 2: FTP ile public_html/ klasörünün İÇERİĞİNİ public_html'e yükleyin
--------------------------------------------------------------------------------
Hedef: /home/KULLANICI_ADI/public_html/
(release/public_html/ içindeki her şeyi public_html'e kopyalayın - üzerine yazın)

İçinde olmalı: index.php, .htaccess, .user.ini, assets/, uploads/, robots.txt


--------------------------------------------------------------------------------
ADIM 3: phpMyAdmin ile SQL import
--------------------------------------------------------------------------------
cPanel > phpMyAdmin > Veritabanı seçin > Import
Dosya: release/sql/full-export.sql
Charset: utf8mb4


--------------------------------------------------------------------------------
ADIM 4: .env oluştur
--------------------------------------------------------------------------------
cPanel > File Manager > backend/ klasörüne girin

.env.production.example dosyasını .env olarak kopyalayın veya:
  cp .env.production.example .env

.env dosyasını düzenleyin (Edit):
  APP_URL=https://siteniz.com
  APP_DEBUG=false
  DB_DATABASE=veritabani_adi
  DB_USERNAME=kullanici
  DB_PASSWORD=sifre


--------------------------------------------------------------------------------
ADIM 5: Terminal (cPanel > Terminal veya SSH)
--------------------------------------------------------------------------------
cd ~/backend
php artisan key:generate
php artisan storage:link
chmod -R 775 storage bootstrap/cache

(Bazı hostlarda storage:link çalışmaz. O zaman:
 cd ~/public_html
 ln -s ../backend/storage/app/public storage
)


--------------------------------------------------------------------------------
KONTROL
--------------------------------------------------------------------------------
- Tarayıcıda siteyi açın
- Görseller, videolar, sponsorlar çalışıyor mu?
- Admin panele giriş yapın

================================================================================
TXT;
file_put_contents($out . '/KURULUM.txt', $kurulum);

// ========== 5. README release kökünde ==========
$readme = <<<'TXT'
RELEASE PAKETI - cPanel KAYIPSIZ KURULUM
========================================

Bu release/ klasörü 3 bölümden oluşur:

1. backend/     -> public_html DIŞINA at (home/backend)
2. public_html/ -> public_html İÇİNE at (içeriğini kopyala)
3. sql/         -> full-export.sql dosyası phpMyAdmin'den import edilecek

Detaylı adımlar: KURULUM.txt
TXT;
file_put_contents($out . '/README.txt', $readme);

echo "\n=== RELEASE HAZIR ===\n";
echo "release/\n";
echo "  backend/     -> public_html DISINA (home/backend)\n";
echo "  public_html/ -> public_html ICINE (icerigini at)\n";
echo "  sql/         -> full-export.sql (phpMyAdmin import)\n";
echo "  KURULUM.txt  -> 5 adimda kurulum\n";

function copyDirContents($src, $dest) {
    if (!is_dir($src)) return;
    if (!is_dir($dest)) mkdir($dest, 0755, true);
    $iter = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($src, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    foreach ($iter as $item) {
        $subPath = $iter->getSubPathname();
        $subPath = str_replace('\\', '/', $subPath);
        $target = $dest . '/' . $subPath;
        if ($item->isDir()) {
            if (!is_dir($target)) mkdir($target, 0755, true);
        } else {
            $d = dirname($target);
            if (!is_dir($d)) mkdir($d, 0755, true);
            copy($item->getPathname(), $target);
        }
    }
}

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
            $d = dirname($target);
            if (!is_dir($d)) mkdir($d, 0755, true);
            copy($item->getPathname(), $target);
        }
    }
}

function rmdirRecursive($dir) {
    if (!is_dir($dir)) return;
    foreach (new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    ) as $path) {
        $path->isDir() ? @rmdir($path->getPathname()) : @unlink($path->getPathname());
    }
    @rmdir($dir);
}

function parseEnv($path) {
    $env = [];
    if (!is_readable($path)) return $env;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (preg_match('/^([^=]+)=(.*)$/', $line, $m)) {
            $key = trim($m[1]);
            $val = trim($m[2], " \t\n\r\0\x0B\"'");
            $env[$key] = $val;
        }
    }
    return $env;
}

function getMysqldumpPath() {
    $paths = ['mysqldump'];
    if (PHP_OS_FAMILY === 'Windows') {
        $laragon = getenv('LARAGON_ROOT') ?: 'C:\\laragon';
        $found = glob($laragon . '\\bin\\mysql\\*\\bin\\mysqldump.exe');
        if (!empty($found)) $paths = array_merge($paths, $found);
    }
    foreach ($paths as $p) {
        $out = [];
        exec(escapeshellcmd($p) . ' --version 2>nul', $out, $r);
        if ($r === 0) return $p;
    }
    return null;
}
