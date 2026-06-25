<?php
/**
 * Unikeyterra — Sunucu Migrasyon Çalıştırıcı
 * Kullandıktan sonra bu dosyayı MUTLAKA SİL!
 *
 * Kullanım: https://unikeyterra.net/migrate.php?key=BURAYA_SIFRE_YAZ&action=status
 *           https://unikeyterra.net/migrate.php?key=BURAYA_SIFRE_YAZ&action=run
 *           https://unikeyterra.net/migrate.php?key=BURAYA_SIFRE_YAZ&action=seed
 */

// ─── BURAYA KENDİ ÖZEL ANAHTARINI YAZ ─────────────────────────────────────
define('SECRET_KEY', 'ukt-migrate-2024');
// ─────────────────────────────────────────────────────────────────────────

error_reporting(E_ALL);
ini_set('display_errors', 0); // Hata mesajlarını ekrana basma
set_time_limit(300);

header('Content-Type: text/html; charset=utf-8');
header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-cache, no-store');

// ─── Güvenlik: Anahtar kontrolü ──────────────────────────────────────────
$key = $_GET['key'] ?? '';
if (!hash_equals(SECRET_KEY, $key)) {
    http_response_code(403);
    echo '<!DOCTYPE html><html><body><h1>403 Forbidden</h1></body></html>';
    exit;
}

$action = $_GET['action'] ?? 'status';
$allowed = ['status', 'run', 'seed', 'fresh'];
if (!in_array($action, $allowed)) {
    $action = 'status';
}

// ─── Stil ────────────────────────────────────────────────────────────────
$style = '
<style>
  body { font-family:monospace; background:#0d1117; color:#c9d1d9; margin:0; padding:20px; }
  h1 { color:#58a6ff; border-bottom:1px solid #30363d; padding-bottom:10px; }
  h2 { color:#79c0ff; }
  pre { background:#161b22; border:1px solid #30363d; padding:15px; border-radius:6px; white-space:pre-wrap; word-break:break-word; }
  .ok { color:#3fb950; }
  .err { color:#f85149; }
  .warn { color:#d29922; }
  .info { color:#58a6ff; }
  .btn { display:inline-block; padding:8px 16px; margin:6px 4px; border-radius:6px; text-decoration:none; font-weight:bold; font-size:14px; }
  .btn-blue { background:#1f6feb; color:#fff; }
  .btn-green { background:#238636; color:#fff; }
  .btn-red { background:#da3633; color:#fff; }
  .btn-gray { background:#21262d; color:#8b949e; border:1px solid #30363d; }
  .box { background:#161b22; border:1px solid #30363d; border-radius:6px; padding:15px; margin:10px 0; }
  .badge { display:inline-block; padding:2px 8px; border-radius:20px; font-size:12px; margin:2px; }
  .badge-green { background:#1a7f37; color:#7ee787; }
  .badge-red { background:#b91c1c; color:#fca5a5; }
</style>';

echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Migrasyon Çalıştırıcı</title>' . $style . '</head><body>';
echo '<h1>Unikeyterra — Veritabanı Migrasyon</h1>';

// ─── Laravel bootstrap ────────────────────────────────────────────────────
$base = dirname(__DIR__);

if (!file_exists($base . '/vendor/autoload.php')) {
    echo '<p class="err">HATA: vendor/autoload.php bulunamadı. Composer çalıştırıldı mı?</p></body></html>';
    exit;
}

if (!file_exists($base . '/.env')) {
    echo '<p class="err">HATA: .env dosyası bulunamadı.</p></body></html>';
    exit;
}

try {
    require $base . '/vendor/autoload.php';
    $app = require_once $base . '/bootstrap/app.php';
    $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
} catch (\Throwable $e) {
    echo '<p class="err">HATA: Laravel başlatılamadı: ' . htmlspecialchars($e->getMessage()) . '</p></body></html>';
    exit;
}

// ─── Eylem Menüsü ─────────────────────────────────────────────────────────
$self = '?key=' . urlencode($key);
echo '<div class="box">';
echo '<b>Eylem seç:</b><br><br>';
echo '<a class="btn btn-blue" href="' . $self . '&action=status">Durum Kontrol</a>';
echo '<a class="btn btn-green" href="' . $self . '&action=run" onclick="return confirm(\'Migrate çalıştırılsın mı?\')">Migrate Çalıştır</a>';
echo '<a class="btn btn-gray" href="' . $self . '&action=seed" onclick="return confirm(\'Seeder çalıştırılsın mı?\')">Seeder Çalıştır</a>';
echo '<a class="btn btn-red" href="' . $self . '&action=fresh" onclick="return confirm(\'DİKKAT: TÜM VERİLER SİLİNECEK! Emin misiniz?\')">Fresh + Seed (Dikkat!)</a>';
echo '</div>';

// ─── Eylem uygula ─────────────────────────────────────────────────────────
echo '<h2>Sonuç: <span class="info">' . strtoupper($action) . '</span></h2>';
echo '<pre>';

try {
    switch ($action) {

        case 'status':
            \Illuminate\Support\Facades\Artisan::call('migrate:status');
            echo htmlspecialchars(\Illuminate\Support\Facades\Artisan::output());
            break;

        case 'run':
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            echo htmlspecialchars(\Illuminate\Support\Facades\Artisan::output());
            break;

        case 'seed':
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
            echo htmlspecialchars(\Illuminate\Support\Facades\Artisan::output());
            break;

        case 'fresh':
            \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
            echo htmlspecialchars(\Illuminate\Support\Facades\Artisan::output());
            break;
    }
} catch (\Throwable $e) {
    echo '<span class="err">HATA: ' . htmlspecialchars($e->getMessage()) . '</span>' . "\n";
    echo htmlspecialchars($e->getTraceAsString());
}

echo '</pre>';

// ─── DB bağlantı testi ────────────────────────────────────────────────────
echo '<h2>Veritabanı Bağlantı Testi</h2>';
echo '<div class="box">';
try {
    $tables = \Illuminate\Support\Facades\DB::select('SHOW TABLES');
    echo '<span class="ok">Bağlantı OK</span> — ' . count($tables) . ' tablo bulundu<br><br>';
    foreach ($tables as $table) {
        $tableName = array_values((array) $table)[0];
        $count = \Illuminate\Support\Facades\DB::table($tableName)->count();
        $badge = $count > 0 ? 'badge-green' : 'badge-red';
        echo '<span class="badge ' . $badge . '">' . $tableName . ' (' . $count . ')</span>';
    }
} catch (\Throwable $e) {
    echo '<span class="err">DB HATASI: ' . htmlspecialchars($e->getMessage()) . '</span>';
}
echo '</div>';

// ─── Sonraki adımlar ──────────────────────────────────────────────────────
echo '<div class="box">';
echo '<b class="warn">Önemli: Bu dosyayı kullandıktan sonra FTP ile sunucudan SİL!</b><br>';
echo '<small>Dosya yolu: /public/migrate.php</small>';
echo '</div>';

echo '</body></html>';
