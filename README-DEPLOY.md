# Unikeyterra Dağıtım Rehberi

## Genel Bilgiler
Bu rehber, Unikeyterra projesini cPanel/LiteSpeed barındırma ortamına dağıtım için hazırlanmıştır.

## Yerel Geliştirme Ortamı

### Docker ile Çalıştırma
```bash
docker-compose up -d
```

### Container'lara Erişim
```bash
# Laravel app container
docker exec -it laravel-app bash

# MySQL container
docker exec -it laravel-mysql mysql -u laravel_user -psecret

# Redis container  
docker exec -it laravel-redis redis-cli
```

## cPanel Dağıtım Adımları

### 1. Yerel Hazırlık
```bash
# Composer paketlerini production için kur
composer install --no-dev --optimize-autoloader

# Frontend asset'lerini derle (eğer varsa)
npm install
npm run build

# Cache'leri oluştur
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. .env.production Dosyası
```env
APP_NAME="Unikeyterra"
APP_ENV=production
APP_KEY=base64:[PRODUCTION_KEY]
APP_DEBUG=false
APP_URL=https://[DOMAIN]

DB_CONNECTION=mysql
DB_HOST=[DB_HOST]
DB_PORT=3306
DB_DATABASE=[DB_NAME]
DB_USERNAME=[DB_USER]
DB_PASSWORD=[DB_PASS]

CACHE_STORE=database
QUEUE_CONNECTION=database
SESSION_DRIVER=database

LOG_CHANNEL=daily
```

### 3. Dizin Yapısı (cPanel)
```
/home/[CPANEL_USER]/
├── laravel/              # Laravel uygulama dosyaları
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   └── .env
└── public_html/          # Public dosyalar
    ├── index.php         # Düzenlenmiş index.php
    ├── .htaccess
    ├── css/
    ├── js/
    ├── images/
    └── uploads/
```

### 4. public/index.php Düzenlemesi
cPanel için index.php dosyasında şu değişiklikleri yapın:
```php
// Vendor autoload yolu
require __DIR__.'/../laravel/vendor/autoload.php';

// Bootstrap app yolu  
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';
```

### 5. FTP ile Yükleme
1. Tüm Laravel dosyalarını `/home/[CPANEL_USER]/laravel/` dizinine yükleyin
2. public klasörü içeriğini `/home/[CPANEL_USER]/public_html/` dizinine yükleyin
3. .env.production dosyasını .env olarak laravel dizinine kopyalayın

### 6. Veritabanı Kurulumu
1. cPanel > MySQL Databases'den veritabanı oluşturun
2. phpMyAdmin'e gidin
3. database/schema.sql dosyasını import edin (eğer varsa)
4. Veya SSH erişimi varsa: `php artisan migrate --force`

### 7. Cron Job Ayarları
cPanel > Cron Jobs bölümünde ekleyin:

**Laravel Scheduler (Her dakika)**
```bash
/opt/cpanel/ea-php83/root/usr/bin/php /home/[CPANEL_USER]/laravel/artisan schedule:run >> /dev/null 2>&1
```

**Queue Worker (Her 5 dakika)**
```bash
/opt/cpanel/ea-php83/root/usr/bin/php /home/[CPANEL_USER]/laravel/artisan queue:work --stop-when-empty --sleep=3 --tries=3 >> /dev/null 2>&1
```

### 8. İzinler
SSH erişiminiz varsa:
```bash
chmod -R 755 /home/[CPANEL_USER]/laravel
chmod -R 775 /home/[CPANEL_USER]/laravel/storage
chmod -R 775 /home/[CPANEL_USER]/laravel/bootstrap/cache
chmod -R 755 /home/[CPANEL_USER]/public_html
```

FTP ile izin değiştirme: storage ve bootstrap/cache dizinlerini 775 yapın.

### 9. php.ini Ayarları
`.htaccess` veya cPanel MultiPHP INI Editor ile:
```ini
memory_limit = 256M
upload_max_filesize = 50M
post_max_size = 50M
max_execution_time = 300
```

## Hata Ayıklama

### Beyaz Ekran / 500 Hatası
1. storage/logs/laravel.log dosyasını kontrol edin
2. APP_DEBUG=true yapıp detaylı hata görün (sadece test için!)
3. İzinleri kontrol edin

### Veritabanı Bağlantı Hatası
1. .env dosyasındaki DB bilgilerini kontrol edin
2. MySQL kullanıcı izinlerini kontrol edin

### Session/Cache Hataları
1. storage/framework/sessions dizininin yazılabilir olduğundan emin olun
2. Database driver kullanıyorsanız, ilgili tabloların oluştuğundan emin olun

## Güvenlik Kontrol Listesi
- [ ] APP_DEBUG=false
- [ ] .env dosyası public erişime kapalı
- [ ] storage dizini public erişime kapalı
- [ ] Gereksiz dosyalar silinmiş (.git, tests, vb.)
- [ ] HTTPS zorunlu yönlendirme aktif

## Performans Optimizasyonu
```bash
# Production optimizasyonları (yerel ortamda çalıştırıp yükleyin)
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --no-dev --optimize-autoloader
```

## Bakım Modu
Bakım moduna almak için public_html dizininde maintenance.html dosyası oluşturun ve .htaccess'e ekleyin:
```apache
RewriteCond %{REQUEST_URI} !^/maintenance\.html$
RewriteCond %{DOCUMENT_ROOT}/maintenance.html -f
RewriteRule ^(.*)$ /maintenance.html [R=503,L]
```
