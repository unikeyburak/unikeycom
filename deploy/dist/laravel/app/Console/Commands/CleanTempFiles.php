<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CleanTempFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:clean-temp {--days=7 : Kaç günden eski dosyalar silinsin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Geçici dosyaları ve eski cache dosyalarını temizler';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $this->info("$days günden eski geçici dosyalar temizleniyor...");
        
        $totalDeleted = 0;
        
        // Framework cache dosyalarını temizle
        $totalDeleted += $this->cleanDirectory(storage_path('framework/cache'), $days);
        
        // View cache dosyalarını temizle
        $totalDeleted += $this->cleanDirectory(storage_path('framework/views'), $days);
        
        // Session dosyalarını temizle
        $totalDeleted += $this->cleanDirectory(storage_path('framework/sessions'), $days);
        
        // Temp upload klasörünü temizle
        if (File::exists(storage_path('app/temp'))) {
            $totalDeleted += $this->cleanDirectory(storage_path('app/temp'), $days);
        }
        
        // Public temp dosyalarını temizle
        if (Storage::disk('public')->exists('temp')) {
            $files = Storage::disk('public')->files('temp');
            foreach ($files as $file) {
                $lastModified = Storage::disk('public')->lastModified($file);
                if ($lastModified < strtotime("-$days days")) {
                    Storage::disk('public')->delete($file);
                    $totalDeleted++;
                }
            }
        }
        
        $this->info("Toplam $totalDeleted dosya temizlendi.");
        
        // Disk kullanımını göster
        $this->showDiskUsage();
        
        return Command::SUCCESS;
    }
    
    /**
     * Belirtilen klasördeki eski dosyaları temizle
     */
    private function cleanDirectory($path, $days): int
    {
        if (!File::exists($path)) {
            return 0;
        }
        
        $deleted = 0;
        $files = File::files($path);
        
        foreach ($files as $file) {
            // .gitignore dosyalarını silme
            if ($file->getFilename() === '.gitignore') {
                continue;
            }
            
            if ($file->getMTime() < strtotime("-$days days")) {
                File::delete($file);
                $deleted++;
            }
        }
        
        return $deleted;
    }
    
    /**
     * Disk kullanım bilgisini göster
     */
    private function showDiskUsage(): void
    {
        $storagePath = storage_path();
        $totalSize = $this->getDirectorySize($storagePath);
        $totalSizeMB = round($totalSize / 1024 / 1024, 2);
        
        $this->info("Storage klasörü toplam boyut: {$totalSizeMB} MB");
    }
    
    /**
     * Klasör boyutunu hesapla
     */
    private function getDirectorySize($path): int
    {
        $size = 0;
        foreach (File::allFiles($path) as $file) {
            $size += $file->getSize();
        }
        return $size;
    }
}
