<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanActivityLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:clean {--days=30 : Kaç günden eski loglar silinsin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Belirtilen günden eski activity loglarını temizler';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $date = now()->subDays($days);
        
        $this->info("$days günden eski activity logları temizleniyor...");
        
        $deletedCount = DB::table('activity_logs')
            ->where('created_at', '<', $date)
            ->delete();
            
        $this->info("$deletedCount adet log kaydı temizlendi.");
        
        // Laravel loglarını da temizle
        $this->cleanLaravelLogs($days);
        
        return Command::SUCCESS;
    }
    
    /**
     * Laravel log dosyalarını temizle
     */
    private function cleanLaravelLogs($days): void
    {
        $logPath = storage_path('logs');
        $files = glob($logPath . '/laravel-*.log');
        
        $deletedFiles = 0;
        foreach ($files as $file) {
            if (filemtime($file) < strtotime("-$days days")) {
                if (unlink($file)) {
                    $deletedFiles++;
                }
            }
        }
        
        if ($deletedFiles > 0) {
            $this->info("$deletedFiles adet eski log dosyası temizlendi.");
        }
    }
}
