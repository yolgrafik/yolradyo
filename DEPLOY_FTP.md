# FTP ile Yayına Alma Rehberi

Bu rehber, RADYOYOL projesini FTP ile sunucuya yüklemek için adımları içerir.

---

## 1. Yüklemeden Önce (Yerelde Yapılacaklar)

### A) Production build
```bash
# Vite/Tailwind asset'lerini derle
npm run build

# Composer bağımlılıklarını production modunda yükle (vendor zaten var ise atla)
composer install --no-dev --optimize-autoloader
```

### B) Cache temizle
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 2. FTP ile Yüklenecek Dosyalar

### ✅ YÜKLE (Gerekli)
| Klasör/Dosya | Açıklama |
|--------------|----------|
| `app/` | Uygulama kodu |
| `bootstrap/` | Laravel bootstrap (cache hariç) |
| `config/` | Konfigürasyon |
| `database/` | Migration, seeders |
| `public/` | **Tüm içerik** (index.php, assets, .htaccess, uploads) |
| `resources/` | Views, js, css kaynakları |
| `routes/` | Route tanımları |
| `storage/` | Klasör yapısı (app, framework, logs) |
| `vendor/` | Composer paketleri |
| `artisan` | CLI aracı |
| `composer.json` | Bağımlılık listesi |
| `composer.lock` | Kilit dosyası |

### ❌ YÜKLEME (Hariç tut)
| Klasör/Dosya | Neden |
|--------------|-------|
| `.env` | Sunucuda ayrı oluşturulacak |
| `.git/` | Versiyon kontrolü, gereksiz |
| `node_modules/` | Çok büyük, build zaten alındı |
| `tests/` | Test dosyaları |
| `.phpunit.cache/` | Test cache |
| `storage/logs/*.log` | Log dosyaları |
| `storage/framework/cache/data/*` | Cache verisi |
| `storage/framework/sessions/*` | Oturum dosyaları |
| `storage/framework/views/*` | Derlenmiş view'lar |
| `.idea/`, `.vscode/` | IDE ayarları |
| `Homestead.yaml` | Yerel geliştirme |

---

## 3. Sunucu Yapılandırması

### A) Document Root
Web sunucunun **document root**'u `public` klasörüne işaret etmeli:

```
Örnek: /home/kullanici/yolcu/public
```

Eğer tüm proje `public_html` içine yükleniyorsa:
- `public/` içeriğini `public_html/` köküne taşı
- Diğer dosyaları `public_html` dışında (örn. `yolcu/`) tut
- `public/index.php` içindeki path'leri güncelle:

```php
// public/index.php - satır 35-36 civarı
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```

Eğer proje `public_html/yolcu` altındaysa:
```php
require __DIR__.'/../../vendor/autoload.php';
$app = require_once __DIR__.'/../../bootstrap/app.php';
```

### B) .env dosyası
Sunucuda `.env.example`'ı kopyalayıp `.env` oluştur:

```bash
cp .env.example .env
```

Düzenle:
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://siteniz.com`
- `DB_*` veritabanı bilgileri

Key üret:
```bash
php artisan key:generate
```

### C) Klasör izinleri
```bash
chmod -R 775 storage bootstrap/cache
# veya
chmod 775 storage
chmod -R 775 storage/*
chmod 775 bootstrap/cache
```

### D) Storage link (dosya yükleme için)
```bash
php artisan storage:link
```

### E) Migration ve cache
```bash
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 4. FTP İstemci Ayarları (FileZilla / WinSCP)

### FileZilla – Dizin Filtreleme
1. **Edit → Directory listing filters**
2. Exclude filters ekle:
   ```
   .git
   node_modules
   .env
   .env.backup
   .env.production
   tests
   .phpunit.cache
   .idea
   .vscode
   storage/logs
   storage/framework/cache/data
   storage/framework/sessions
   storage/framework/views
   Homestead.yaml
   *.log
   ```

### WinSCP – Yükleme filtresi
**Preferences → Transfer → Transfer resume/transfer to temporary file name**  
veya **Transfer Settings → File mask** ile exclude pattern kullan.

---

## 5. Kontrol Listesi

- [ ] `npm run build` çalıştırıldı
- [ ] `composer install --no-dev` çalıştırıldı
- [ ] `.env` sunucuda oluşturuldu
- [ ] `php artisan key:generate` çalıştırıldı
- [ ] Document root `public` klasörüne ayarlandı
- [ ] `storage` ve `bootstrap/cache` yazılabilir (775)
- [ ] `php artisan migrate --force` çalıştırıldı
- [ ] `php artisan storage:link` çalıştırıldı
- [ ] Config/route/view cache alındı

---

## 6. Sorun Giderme

| Sorun | Çözüm |
|-------|-------|
| 500 Internal Server Error | `storage/logs/laravel.log` kontrol et, izinleri kontrol et |
| CSS/JS yüklenmiyor | `public/build` klasörünün yüklendiğinden emin ol |
| Görsel yüklenmiyor | `php artisan storage:link`, `public/uploads` izinleri |
| Veritabanı hatası | `.env` DB bilgilerini kontrol et |
| Session hatası | `storage/framework/sessions` yazılabilir olmalı |
