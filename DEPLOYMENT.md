# cPanel / public_html Deployment Klavuzu

Bu proje **tamamen public_html** icerisine yuklenecek sekilde hazirlanmistir. Veri, medya, ayar kaybi olmadan calisir.

## Hizli Baslangic

```bash
php deploy-cpanel.php
```

Cikti: `release/` klasoru. Bu klasorun **icerigini** FTP ile `public_html`e yukleyin.

---

## 1. Degistirilen / Olusturulan Dosyalar

| Dosya | Aciklama |
|-------|----------|
| `release/index.php` | Kok giris noktasi, backend yolcu/ icinden bootstrap |
| `release/.htaccess` | public/.htaccess ile ayni (rewrite kurallari) |
| `release/.user.ini` | cPanel PHP limitleri (128M upload, video icin) |
| `release/yolcu/.htaccess` | Backend klasorune dogrudan HTTP erisim engeli |
| `release/yolcu/bootstrap/app.php` | `usePublicPath(document_root)` eklendi |
| `deploy-cpanel.php` | Deployment script (guncellendi) |
| `app/Console/Commands/ExportDatabaseCommand.php` | `php artisan db:export` komutu |

## 2. public_html Icin Klasor Yapisi

```
public_html/
├── index.php
├── .htaccess
├── .user.ini
├── assets/
├── uploads/              # Direkt yuklenen medya
│   ├── about-pages/
│   ├── avatars/
│   ├── gallery/
│   ├── news/
│   ├── sliders/
│   ├── sponsors/
│   │   ├── videos/
│   │   └── video-posters/
│   └── videos/
├── storage/              # php artisan storage:link sonrasi symlink
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
    │   └── app/public/
    └── vendor/
```

## 3. index.php Degisiklikleri

- `__DIR__` = public_html (document root)
- `$backendDir = __DIR__ . '/yolcu'`
- `require $backendDir . '/vendor/autoload.php'`
- `require $backendDir . '/bootstrap/app.php'`

## 4. .htaccess

Kok .htaccess: Tum istekler (dizin/dosya degilse) index.php'ye yonlendirilir.

## 5. Storage / Medya Koruma

| Konum | Icerik |
|-------|--------|
| `public_html/uploads/` | Sponsor, haber, slider, galeri, video, avatar (direkt public_path) |
| `public_html/storage/` | Symlink -> yolcu/storage/app/public |
| `yolcu/storage/app/public/` | Logo, favicon, OG görsel, tema arkaplan, forum, uye yuklemeleri |

**Symlink sorunu:** cPanel Terminal'de `php artisan storage:link` calistirin. Calismazsa:
```bash
cd ~/public_html
ln -s yolcu/storage/app/public storage
```

## 6. Kritik Medya Klasorleri (Kayip Olmamali)

- `uploads/sponsors/`
- `uploads/sponsors/videos/`
- `uploads/sponsors/video-posters/`
- `uploads/news/`
- `uploads/news/gallery/`
- `uploads/gallery/photos/`
- `uploads/gallery/albums/`
- `uploads/sliders/`
- `uploads/videos/mp4/`
- `uploads/videos/covers/`
- `uploads/avatars/`
- `uploads/about-pages/`
- `storage/app/public/` (forum, uye, logo, favicon, tema)

## 7. Production .env Ana Ayarlar

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://siteniz.com
FILESYSTEM_DISK=local
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...
```

## 8. SQL Export / Import

**Export (yerelde):**
```bash
php artisan db:export
```

Dosya: `database/full-export.sql`

**Import (cPanel phpMyAdmin):**
1. Veritabanini secin
2. Import > Dosya sec: `yolcu/database/full-export.sql`
3. Charset: utf8mb4
4. Go

**Not:** full-export.sql tablo yapisi + tum verileri icerir. Migration calistirmaya gerek yoktur.

## 9. cPanel Yukleme Sonrasi Kontrol Listesi

- [ ] Tum dosyalar public_html icinde
- [ ] .env olusturuldu ve duzenlendi
- [ ] `php artisan key:generate`
- [ ] `php artisan storage:link`
- [ ] `chmod -R 775 storage bootstrap/cache`
- [ ] Veritabani import edildi
- [ ] PHP 8.2+ secildi
- [ ] Site aciliyor

## 10. Riskli Noktalar

- **Symlink:** Bazı hostlarda devre disi. storage:link sonrasi manuel `ln -s` gerekebilir.
- **Yazma izinleri:** storage ve bootstrap/cache 775 olmali.
- **Büyük dosya:** .user.ini 128M. Hosting limiti dusukse artirilamayabilir.

## 11. Ozet

Proje public_html kokunden calisacak sekilde hazirdir. Backend `yolcu/` altindadir. Deployment script tum medya ve veriyi kopyalar. Veri kaybi olmadan yayina alinabilir.
