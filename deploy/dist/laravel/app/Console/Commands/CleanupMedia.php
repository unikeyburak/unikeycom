<?php

namespace App\Console\Commands;

use App\Services\MediaService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CleanupMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:cleanup {--days=30 : Kaç günden eski dosyalar silinsin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kullanılmayan medya dosyalarını temizle';

    /**
     * Execute the console command.
     */
    public function handle(MediaService $mediaService): void
    {
        $days = (int) $this->option('days');
        
        $this->info("Temizlik başlatılıyor ({$days} günden eski dosyalar)...");
        
        try {
            $deletedCount = $mediaService->cleanupUnusedMedia($days);
            
            $this->info("✓ {$deletedCount} adet dosya temizlendi");
            
            Log::info('Medya temizliği tamamlandı', [
                'deleted_count' => $deletedCount,
                'days_old' => $days
            ]);
        } catch (\Exception $e) {
            $this->error('Temizlik sırasında hata oluştu: ' . $e->getMessage());
            
            Log::error('Medya temizliği başarısız', [
                'error' => $e->getMessage()
            ]);
        }
    }
}