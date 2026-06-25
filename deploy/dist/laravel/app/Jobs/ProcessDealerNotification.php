<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ProcessDealerNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Job'ın kaç kez tekrar denenebileceği
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Job'ın timeout süresi (saniye)
     *
     * @var int
     */
    public $timeout = 120;

    /**
     * E-posta gönderilecek adres
     */
    protected string $email;

    /**
     * E-posta konusu
     */
    protected string $subject;

    /**
     * E-posta içeriği
     */
    protected string $content;

    /**
     * Create a new job instance.
     */
    public function __construct(string $email, string $subject, string $content)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::raw($this->content, function ($message) {
                $message->to($this->email)
                    ->subject($this->subject);
            });
            
            Log::info('Bayi bildirimi gönderildi', [
                'email' => $this->email,
                'subject' => $this->subject
            ]);
        } catch (\Exception $e) {
            Log::error('Bayi bildirimi gönderilemedi', [
                'email' => $this->email,
                'error' => $e->getMessage()
            ]);
            
            throw $e; // Job'ın yeniden denenmesi için
        }
    }

    /**
     * Job başarısız olduğunda çalışacak method
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Bayi bildirim job\'ı başarısız oldu', [
            'email' => $this->email,
            'subject' => $this->subject,
            'error' => $exception->getMessage()
        ]);
    }
}
