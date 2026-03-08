<?php
/**
 * cPanel Deployment Script - public_html Uyumlu
 *
 * Tüm proje public_html içine yüklenecek. Veri, medya, ayar kaybı olmadan.
 * Backend: yolcu/ altında | Kök: index.php, .htaccess, assets, uploads
 *
 * Kullanım: php deploy-cpanel.php
 * Çıktı: release/ → FTP ile public_html'e yükleyin
 */

$root = __DIR__;
$out = $root . '/release';
$backend = 'yolcu';

echo "=== cPanel Deployment Hazirligi ===\n\n";

if (is_dir($out)) {
    echo "Mevcut release siliniyor...\n";
    rmdirRecursive($out);
}
mkdir($out, 0755, true);
mkdir($out . '/' . $backend, 0755, true);

// 1. public/ icerigini deploy kokune kopyala (index.php, .htaccess, storage symlink haric)
$pubSrc = $root . '/public';
$pubIter = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($pubSrc, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);
$skipPub = ['index.php', '.htaccess', '.gitignore'];
foreach ($pubIter as $item) {
    $subPath = str_replace($pubSrc . DIRECTORY_SEPARATOR, '', $item->getPathname());
    $subPath = str_replace('\\', '/', $subPath);
    if (in_array(basename($subPath), $skipPub) && strpos($subPath, '/') === false) continue;
    if ($subPath === 'storage' && $item->isDir()) continue; // symlink - kopyalanmaz
    $target = $out . '/' . $subPath;
    if ($item->isDir()) {
        if (!is_dir($target)) mkdir($target, 0755, true);
    } else {
        $targetDir = dirname($target);
        if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
        copy($item->getPathname(), $target);
    }
}
echo "  [OK] public/ icerigi (assets, uploads, robots.txt) kopyalandi\n";

// 2. storage/app/public icerigini yolcu/storage/app/public'e kopyala (logo, favicon, forum, tema vb.)
$storagePublic = $root . '/storage/app/public';
$storageDest = $out . '/' . $backend . '/storage/app/public';
if (is_dir($storagePublic)) {
    mkdir($storageDest, 0755, true);
    copyDirContents($storagePublic, $storageDest);
    echo "  [OK] storage/app/public (logo, favicon, forum, tema dosyalari) kopyalandi\n";
}

// 3. Backend klasorleri
$backendDirs = ['app', 'bootstrap', 'config', 'database', 'resources', 'routes', 'storage', 'vendor'];
foreach ($backendDirs as $dir) {
    $src = $root . '/' . $dir;
    if (!is_dir($src) && $dir !== 'storage') {
        echo "  UYARI: $dir bulunamadi.\n";
        continue;
    }
    if ($dir === 'storage') {
        $storageDirs = ['app', 'app/public', 'framework', 'framework/cache', 'framework/cache/data', 'framework/sessions', 'framework/views', 'logs'];
        foreach ($storageDirs as $s) {
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
        // cPanel: public path = document root (backend'in ustu)
        $bootstrapApp = file_get_contents($out . '/' . $backend . '/bootstrap/app.php');
        $bootstrapApp = str_replace('return Application::configure', '$app = Application::configure', $bootstrapApp);
        $bootstrapApp = str_replace(')->create();', ')->create();' . "\n" . '$app->usePublicPath(dirname($app->basePath()));' . "\n" . 'return $app;', $bootstrapApp);
        file_put_contents($out . '/' . $backend . '/bootstrap/app.php', $bootstrapApp);
    } else {
        copyDirExclude($src, $out . '/' . $backend . '/' . $dir, ['.git', 'node_modules', '.env']);
    }
}
echo "  [OK] Backend klasorleri kopyalandi\n";

// 4. index.php
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

// 5. artisan, composer, .env
foreach (['artisan', 'composer.json', 'composer.lock'] as $f) {
    if (file_exists($root . '/' . $f)) {
        copy($root . '/' . $f, $out . '/' . $backend . '/' . $f);
    }
}
copy($root . '/.env.example', $out . '/' . $backend . '/.env.example');

// 6. yolcu/.htaccess - Backend'e dogrudan erisim engelle
$yolcuHtaccess = <<<'HTA'
<IfModule mod_authz_core.c>
    Require all denied
</IfModule>
<IfModule !mod_authz_core.c>
    Order deny,allow
    Deny from all
</IfModule>
HTA;
file_put_contents($out . '/' . $backend . '/.htaccess', $yolcuHtaccess);

// 7. Kok .htaccess
copy($root . '/public/.htaccess', $out . '/.htaccess');

// 8. .user.ini (cPanel PHP - video yukleme icin yuksek limit)
$userIni = <<<'INI'
; cPanel PHP - production
upload_max_filesize = 128M
post_max_size = 128M
max_execution_time = 180
memory_limit = 256M
max_input_time = 180
default_charset = "UTF-8"
INI;
file_put_contents($out . '/.user.ini', $userIni);

// 9. SQL export - artisan db:export veya mysqldump
$sqlPath = $out . '/' . $backend . '/database';
$fullSqlFile = $sqlPath . '/full-export.sql';
if (file_exists($root . '/.env')) {
    // Once artisan db:export dene (Laravel config kullanir)
    $artisanOut = [];
    $prevCwd = getcwd();
    chdir($root);
    exec('php artisan db:export --output=database/full-export.sql 2>&1', $artisanOut, $artisanRet);
    chdir($prevCwd);
    if ($artisanRet === 0 && file_exists($root . '/database/full-export.sql')) {
        copy($root . '/database/full-export.sql', $fullSqlFile);
        echo "  [OK] php artisan db:export ile full-export.sql olusturuldu\n";
    } else {
        $env = parseEnv($root . '/.env');
        $dbName = $env['DB_DATABASE'] ?? '';
        $dbUser = $env['DB_USERNAME'] ?? '';
        $dbPass = $env['DB_PASSWORD'] ?? '';
        $dbHost = $env['DB_HOST'] ?? '127.0.0.1';
        if ($dbName && $dbUser) {
            $mysqldump = getMysqldumpPath();
            if ($mysqldump) {
                $host = escapeshellarg($dbHost);
                $user = escapeshellarg($dbUser);
                $db = escapeshellarg($dbName);
                $cmd = $mysqldump . " -h $host -u $user " . ($dbPass ? '-p' . escapeshellarg($dbPass) . ' ' : '') . "$db --single-transaction --routines --triggers 2>nul";
                $output = shell_exec($cmd);
                if ($output && strlen(trim($output)) > 100) {
                    file_put_contents($fullSqlFile, $output);
                    echo "  [OK] Veritabani full-export.sql olusturuldu (mysqldump)\n";
                } else {
                    echo "  [--] mysqldump calistirilamadi (manuel: php artisan db:export)\n";
                }
            } else {
                echo "  [--] mysqldump bulunamadi (manuel: php artisan db:export)\n";
            }
        }
    }
}
if (!file_exists($fullSqlFile) && file_exists($root . '/database/schema.sql')) {
    copy($root . '/database/schema.sql', $fullSqlFile);
    echo "  [OK] schema.sql kopyalandi (full-export.sql)\n";
}

// 10. DEPLOYMENT.md ve KURULUM.txt
$kurulum = <<<'TXT'
CPANEL / public_html KURULUM
=============================

1. FTP ile release/ ICERIGINI public_html'e yukleyin.
   Tum dosyalar public_html icinde olmali: index.php, .htaccess, assets, uploads, yolcu/

2. cPanel > MySQL: Yeni veritabani + kullanici olusturup yetki verin.

3. cPanel > phpMyAdmin: Veritabani secin > Import
   Dosya: yolcu/database/full-export.sql (veya schema.sql)
   Charset: utf8mb4
   ONEMLI: Import once "DROP TABLE IF EXISTS" ile tablolari siler, sonra yeniden olusturur.

4. cPanel > Terminal veya SSH:
   cd ~/public_html/yolcu
   cp .env.example .env
   nano .env   # veya File Manager ile duzenle

5. .env zorunlu alanlar:
   APP_URL=https://siteniz.com
   APP_DEBUG=false
   DB_DATABASE=veritabani_adi
   DB_USERNAME=kullanici
   DB_PASSWORD=sifre

6. Devam:
   php artisan key:generate
   php artisan storage:link
   chmod -R 775 storage bootstrap/cache

7. cPanel > MultiPHP: PHP 8.2 veya 8.3

8. Tarayicida siteyi acin.
TXT;
file_put_contents($out . '/KURULUM.txt', $kurulum);

// DEPLOYMENT.md - tam rapor
$deployMd = generateDeploymentMd($backend);
file_put_contents($out . '/DEPLOYMENT.md', $deployMd);

echo "\n=== release/ HAZIR ===\n";
echo "FTP ile release/ ICERIGINI public_html/ klasorune yukleyin.\n";
echo "Sunucuda: cd ~/public_html/{$backend} && cp .env.example .env && php artisan key:generate && php artisan storage:link\n";

function copyDirContents($src, $dest) {
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
    $paths = ['mysqldump', 'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe'];
    foreach ($paths as $p) {
        $out = [];
        exec($p . ' --version 2>nul', $out, $r);
        if ($r === 0) return $p;
    }
    return null;
}

function generateDeploymentMd($backend) {
    return <<<MD
# cPanel Deployment Raporu

## 1. Degistirilen / Olusturulan Dosyalar

- `release/index.php` - Kok giris, backend yolcu/ icinden bootstrap
- `release/.htaccess` - public/.htaccess ile ayni (rewrite)
- `release/.user.ini` - cPanel PHP limitleri (128M upload)
- `release/yolcu/.htaccess` - Backend klasorune dogrudan erisim engeli
- `release/yolcu/bootstrap/app.php` - usePublicPath(document_root) eklendi

## 2. public_html Klasor Yapisi

\`\`\`
public_html/
├── index.php
├── .htaccess
├── .user.ini
├── assets/
├── uploads/           # Direkt yuklenen: sponsor, haber, slider, galeri, video, avatar
│   ├── about-pages/
│   ├── avatars/
│   ├── gallery/
│   ├── news/
│   ├── sliders/
│   ├── sponsors/
│   │   ├── videos/
│   │   └── video-posters/
│   └── videos/
├── storage/           # php artisan storage:link sonrasi symlink (yolcu/storage/app/public)
├── robots.txt
└── yolcu/
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    │   └── full-export.sql
    ├── resources/
    ├── routes/
    ├── storage/
    │   └── app/public/  # Logo, favicon, forum, tema, uye yuklemeleri
    └── vendor/
\`\`\`

## 3. index.php Degisiklikleri

- \`__DIR__\` = public_html (document root)
- \`\$backendDir = __DIR__ . '/yolcu'\`
- require \`\$backendDir . '/vendor/autoload.php'\`
- require \`\$backendDir . '/bootstrap/app.php'\`

## 4. .htaccess

Kok .htaccess: public/.htaccess ile ayni. Tum istekler index.php'ye yonlendirilir.

## 5. Storage / Medya Koruma

| Konum | Icerik |
|-------|--------|
| public_html/uploads/ | Sponsor, haber, slider, galeri, video, avatar (direkt public_path) |
| public_html/storage/ | Symlink -> yolcu/storage/app/public |
| yolcu/storage/app/public/ | Logo, favicon, OG, tema arkaplan, forum, uye yuklemeleri |

Symlink sorunu: cPanel Terminal'de \`php artisan storage:link\` calistirin. Calismazsa:
\`ln -s ../yolcu/storage/app/public storage\` (public_html icinden)

## 6. Kritik Medya Klasorleri

- uploads/sponsors/
- uploads/sponsors/videos/
- uploads/sponsors/video-posters/
- uploads/news/
- uploads/news/gallery/
- uploads/gallery/photos/
- uploads/gallery/albums/
- uploads/sliders/
- uploads/videos/mp4/
- uploads/videos/covers/
- uploads/avatars/
- uploads/about-pages/
- storage/app/public/ (forum, uye, logo, favicon, tema)

## 7. Production .env

\`\`\`
APP_ENV=production
APP_DEBUG=false
APP_URL=https://siteniz.com
FILESYSTEM_DISK=local
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
LOG_LEVEL=error
DB_* = cPanel MySQL bilgileri
\`\`\`

## 8. SQL Import Notlari

- Dosya: yolcu/database/full-export.sql
- Charset: utf8mb4
- Import oncesi mevcut tablolar DROP edilebilir
- Migration calistirmaya gerek yok (SQL tam)

## 9. cPanel Yukleme Sonrasi Kontrol

- [ ] storage:link calisti mi?
- [ ] chmod 775 storage bootstrap/cache
- [ ] .env dogru mu?
- [ ] php artisan key:generate
- [ ] Veritabani baglanti test

## 10. Riskli Noktalar

- Symlink: Bazı hostlarda devre disi. storage:link sonrasi manuel ln -s gerekebilir.
- Yazma izinleri: storage ve bootstrap/cache 775 olmali.

## 11. Ozet

Proje public_html kokunden calisacak sekilde hazir. Backend yolcu/ altinda. Tum medya ve veri kaybi olmadan yuklenir.
MD;
}
