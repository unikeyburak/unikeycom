# cPanel Cron Job Kurulumu

Bu dokümanda Unikeyterra uygulaması için gerekli cron job'ların cPanel üzerinde nasıl kurulacağı açıklanmaktadır.

## Gereksinimler

- cPanel erişimi
- PHP CLI erişimi (genellikle shared hosting'lerde mevcuttur)
- Doğru PHP versiyonu (8.2 veya 8.3)

## PHP Binary Yolunu Bulma

Öncelikle hosting'inizde PHP binary dosyasının yolunu bulmanız gerekiyor. Genellikle şu yollardan birindedir:

- `/opt/cpanel/ea-php82/root/usr/bin/php`
- `/opt/cpanel/ea-php83/root/usr/bin/php`
- `/usr/local/bin/php`
- `/usr/bin/php`

cPanel'de "Select PHP Version" bölümünden kullandığınız PHP versiyonunu kontrol edebilirsiniz.

## Cron Job'ları Ekleme

cPanel > Advanced > Cron Jobs bölümüne gidin.

### 1. Laravel Schedule Runner (Zorunlu)

Bu cron job, Laravel'in zamanlanmış görevlerini çalıştırır.

**Komut:**
```bash
/opt/cpanel/ea-php82/root/usr/bin/php /home/CPANEL_KULLANICI_ADI/laravel/artisan schedule:run >> /dev/null 2>&1
```

**Zaman Ayarı:** Her dakika (* * * * *)

### 2. Queue Worker (Zorunlu)

E-posta gönderimi ve diğer arka plan işleri için gereklidir.

**Komut:**
```bash
/opt/cpanel/ea-php82/root/usr/bin/php /home/CPANEL_KULLANICI_ADI/laravel/artisan queue:work --stop-when-empty --sleep=3 --tries=3 --max-time=50 >> /dev/null 2>&1
```

**Zaman Ayarı:** Her dakika (* * * * *)

**Not:** `--max-time=50` parametresi işlemin 50 saniye sonra durmasını sağlar. Bu shared hosting'lerde timeout problemlerini önler.

### 3. Queue Restart (Opsiyonel ama Önerilen)

Cache değişikliklerinin queue worker'a yansıması için.

**Komut:**
```bash
/opt/cpanel/ea-php82/root/usr/bin/php /home/CPANEL_KULLANICI_ADI/laravel/artisan queue:restart >> /dev/null 2>&1
```

**Zaman Ayarı:** Her 30 dakikada bir (*/30 * * * *)

## Zaman Ayarları Tablosu

| Görev | Dakika | Saat | Gün | Ay | Hafta Günü | Açıklama |
|-------|--------|------|-----|----|-----------:|----------|
| Schedule Runner | * | * | * | * | * | Her dakika |
| Queue Worker | * | * | * | * | * | Her dakika |
| Queue Restart | */30 | * | * | * | * | Her 30 dakikada |

## Zamanlanmış Görevler

`routes/console.php` dosyasında tanımlanan görevler:

1. **Sitemap Güncelleme** - Her gün saat 02:00
2. **Log Temizliği** - Her Pazar saat 03:00
3. **Cache Temizliği** - Haftalık
4. **Queue Monitoring** - Her 10 dakikada bir
5. **Temp Dosya Temizliği** - Her gün saat 04:00

## Log Kontrolü

Cron job'ların çalışıp çalışmadığını kontrol etmek için:

1. Laravel log dosyalarını kontrol edin: `storage/logs/laravel.log`
2. cPanel'de cron job geçmişini görüntüleyin
3. E-posta bildirimlerini kontrol edin (cron çıktıları e-posta ile gönderilebilir)

## Sorun Giderme

### Cron Job Çalışmıyor

1. PHP binary yolunun doğru olduğundan emin olun
2. Dosya yollarının doğru olduğunu kontrol edin
3. Dosya izinlerini kontrol edin (artisan dosyası çalıştırılabilir olmalı)

### Memory Limit Hatası

PHP memory limit'i düşükse şu parametreyi ekleyin:
```bash
/opt/cpanel/ea-php82/root/usr/bin/php -d memory_limit=256M /home/...
```

### Execution Time Hatası

Max execution time için:
```bash
/opt/cpanel/ea-php82/root/usr/bin/php -d max_execution_time=300 /home/...
```

## E-posta Bildirimleri

Cron job çıktılarının e-posta ile gönderilmesini istemiyorsanız komutun sonuna `>> /dev/null 2>&1` ekleyin.

Sadece hataları almak için: `>> /dev/null 2>&1` yerine `>> /home/CPANEL_KULLANICI_ADI/cron.log 2>&1` kullanabilirsiniz.

## Önemli Notlar

1. **CPANEL_KULLANICI_ADI** kısmını kendi cPanel kullanıcı adınızla değiştirin
2. PHP versiyonunu kontrol edip doğru binary yolunu kullanın
3. Shared hosting limitlerine dikkat edin (CPU, memory, execution time)
4. Queue worker'ın sürekli çalışmaması için `--stop-when-empty` parametresi önemli
5. Log dosyalarının boyutunu düzenli kontrol edin

## Test Etme

Cron job'ları manuel olarak test etmek için SSH erişiminiz varsa:

```bash
php artisan schedule:run
php artisan queue:work --stop-when-empty
```

SSH erişiminiz yoksa, cPanel'den bir test cron job'ı oluşturup hemen çalıştırabilirsiniz.