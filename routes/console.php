<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Scheduled Tasks
|--------------------------------------------------------------------------
|
| Burada uygulamanın zamanlanmış görevlerini tanımlıyoruz.
| cPanel'de schedule:run komutu dakikada bir çalıştırılacak.
|
*/

// Sitemap'i günlük olarak güncelle (gece 02:00)
Schedule::command('sitemap:generate')->dailyAt('02:00');

// Eski activity log'larını temizle (30 günden eski kayıtlar)
Schedule::command('logs:clean')->weekly()->sundays()->at('03:00');

// Cache temizliği (haftalık)
Schedule::command('cache:prune-stale-tags')->weekly();

// Failed job'ları kontrol et ve admin'e bildir
Schedule::command('queue:monitor')->everyTenMinutes();

// Geçici dosyaları temizle
Schedule::command('storage:clean-temp')->daily()->at('04:00');

// Veritabanı yedekleme (opsiyonel - hosting'e göre ayarlanacak)
// Schedule::command('backup:run')->daily()->at('01:00');

// Medya temizliği - Eski/kullanılmayan dosyaları temizle
Schedule::command('media:cleanup --days=30')->weekly()->mondays()->at('04:00');
