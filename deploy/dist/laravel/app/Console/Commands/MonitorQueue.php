<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MonitorQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:monitor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queue durumunu kontrol eder ve sorun varsa admin\'e bildirir';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Queue durumu kontrol ediliyor...');
        
        // Failed job'ları kontrol et
        $failedJobs = DB::table('failed_jobs')->count();
        
        if ($failedJobs > 0) {
            $this->error("$failedJobs adet başarısız job bulundu!");
            
            // Admin'e bildirim gönder
            $this->notifyAdmin($failedJobs);
        }
        
        // Bekleyen job'ları kontrol et
        $pendingJobs = DB::table('jobs')->count();
        $this->info("Bekleyen job sayısı: $pendingJobs");
        
        // 100'den fazla bekleyen job varsa uyarı
        if ($pendingJobs > 100) {
            $this->warn("Bekleyen job sayısı yüksek! Queue worker'ların çalıştığından emin olun.");
            Log::warning("Queue'da bekleyen job sayısı yüksek: $pendingJobs");
        }
        
        // En eski bekleyen job'u kontrol et
        $oldestJob = DB::table('jobs')
            ->orderBy('created_at', 'asc')
            ->first();
            
        if ($oldestJob) {
            $age = now()->diffInMinutes($oldestJob->created_at);
            if ($age > 60) {
                $this->warn("En eski job $age dakikadır bekliyor!");
                Log::warning("Queue'da çok uzun süredir bekleyen job var: $age dakika");
            }
        }
        
        return Command::SUCCESS;
    }
    
    /**
     * Admin'e failed job bildirimi gönder
     */
    private function notifyAdmin($failedCount): void
    {
        try {
            $adminEmails = config('mail.admin_emails', ['admin@unikeyterra.com']);
            
            foreach ($adminEmails as $email) {
                Mail::raw(
                    "Unikeyterra Queue Uyarısı\n\n" .
                    "Sistemde $failedCount adet başarısız job bulunmaktadır.\n\n" .
                    "Lütfen admin panelinden kontrol ediniz.\n\n" .
                    "Tarih: " . now()->format('d.m.Y H:i'),
                    function ($message) use ($email) {
                        $message->to($email)
                            ->subject('Queue Hatası - Unikeyterra');
                    }
                );
            }
        } catch (\Exception $e) {
            Log::error('Queue monitor email gönderilemedi: ' . $e->getMessage());
        }
    }
}
