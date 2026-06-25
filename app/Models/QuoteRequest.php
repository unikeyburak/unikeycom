<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteRequest extends Model
{
    /**
     * Toplu atanabilir alanlar
     *
     * @var array<string>
     */
    protected $fillable = [
        'dealer_id',
        'product_id',
        'quantity',
        'unit',
        'delivery_city',
        'delivery_date',
        'usage_purpose',
        'payment_method',
        'notes',
        'status',
        'admin_notes',
        'status_history',
    ];

    /**
     * Tarih alanları
     *
     * @var array<string>
     */
    protected $casts = [
        'quantity' => 'integer',
        'delivery_date' => 'date',
        'status_history' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * İlişkili bayi
     */
    public function dealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class);
    }

    /**
     * İlişkili ürün
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Durum renklerini döndürür
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'processing' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Durum etiketlerini döndürür
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Beklemede',
            'processing' => 'İşleniyor',
            'completed' => 'Tamamlandı',
            'cancelled' => 'İptal Edildi',
            default => 'Bilinmiyor'
        };
    }

    /**
     * Ödeme yöntemi etiketini döndürür
     */
    public function getPaymentMethodLabelAttribute(): string
    {
        return $this->payment_method ?? 'Belirtilmemiş';
    }

    /**
     * Durum geçmişine yeni kayıt ekler
     */
    public function addStatusHistory(string $status, ?string $note = null): void
    {
        $history = $this->status_history ?? [];
        
        $history[] = [
            'status' => $status,
            'date' => now()->toISOString(),
            'note' => $note,
            'user' => auth()->user()?->name ?? 'Sistem'
        ];
        
        $this->update([
            'status' => $status,
            'status_history' => $history
        ]);
    }
}