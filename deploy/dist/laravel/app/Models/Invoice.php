<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'dealer_id',
        'total_amount',
        'tax_amount',
        'discount_amount',
        'net_amount',
        'status',
        'due_date',
        'paid_at',
        'payment_method',
        'payment_reference',
        'notes',
        'generated_by',
        'generated_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_at' => 'datetime',
        'generated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            if (empty($invoice->invoice_number)) {
                $invoice->invoice_number = static::generateInvoiceNumber();
            }

            if (empty($invoice->due_date)) {
                $invoice->due_date = static::calculateDueDate($invoice->dealer_id);
            }

            if (empty($invoice->generated_at)) {
                $invoice->generated_at = now();
            }
        });

        static::created(function ($invoice) {
            $invoice->logActivity('created', $invoice->generated_by);
        });
    }

    /**
     * Generate a unique invoice number.
     */
    protected static function generateInvoiceNumber()
    {
        $prefix = 'INV';
        $year = now()->format('Y');
        
        $lastInvoice = static::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastInvoice ? intval(substr($lastInvoice->invoice_number, -6)) + 1 : 1;
        
        return sprintf('%s-%s-%06d', $prefix, $year, $sequence);
    }

    /**
     * Calculate due date based on dealer payment terms.
     */
    protected static function calculateDueDate($dealerId)
    {
        $dealer = Dealer::find($dealerId);
        $paymentTerms = $dealer->payment_terms ?? 30;
        
        return now()->addDays($paymentTerms);
    }

    /**
     * Get the dealer that owns the invoice.
     */
    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }

    /**
     * Get the orders for the invoice.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the user who generated the invoice.
     */
    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    /**
     * Get the activity logs for the invoice.
     */
    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    /**
     * Scope a query to only include invoices with a specific status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include pending invoices.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include paid invoices.
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope a query to only include overdue invoices.
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue')
            ->orWhere(function ($q) {
                $q->where('status', 'pending')
                    ->where('due_date', '<', now());
            });
    }

    /**
     * Check if the invoice is pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the invoice is paid.
     */
    public function isPaid()
    {
        return $this->status === 'paid';
    }

    /**
     * Check if the invoice is cancelled.
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    /**
     * Check if the invoice is overdue.
     */
    public function isOverdue()
    {
        return $this->status === 'overdue' || 
               ($this->status === 'pending' && $this->due_date < now());
    }

    /**
     * Mark the invoice as paid.
     */
    public function markAsPaid($paymentMethod, $paymentReference = null)
    {
        $this->update([
            'status' => 'paid',
            'paid_at' => now(),
            'payment_method' => $paymentMethod,
            'payment_reference' => $paymentReference,
        ]);

        $this->logActivity('paid', null, [
            'payment_method' => $paymentMethod,
            'payment_reference' => $paymentReference,
        ]);
    }

    /**
     * Cancel the invoice.
     */
    public function cancel($userId, $reason = null)
    {
        $this->update([
            'status' => 'cancelled',
        ]);

        $this->logActivity('cancelled', $userId, ['reason' => $reason]);
    }

    /**
     * Update invoice status based on due date.
     */
    public function updateOverdueStatus()
    {
        if ($this->isPending() && $this->due_date < now()) {
            $this->update(['status' => 'overdue']);
            $this->logActivity('marked_overdue');
        }
    }

    /**
     * Calculate totals from orders.
     */
    public function calculateTotals()
    {
        $totalAmount = 0;

        // In a real implementation, you would calculate based on order items and prices
        // This is a simplified version
        $orderCount = $this->orders()->count();
        $totalAmount = $orderCount * 1000; // Example calculation

        $taxRate = 0.1; // 10% tax
        $taxAmount = $totalAmount * $taxRate;
        
        $discountAmount = 0;
        if ($totalAmount > 10000) {
            $discountAmount = $totalAmount * 0.05; // 5% discount for large orders
        }

        $netAmount = $totalAmount + $taxAmount - $discountAmount;

        $this->update([
            'total_amount' => $totalAmount,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'net_amount' => $netAmount,
        ]);
    }

    /**
     * Log activity for the invoice.
     */
    protected function logActivity($action, $userId = null, $data = [])
    {
        $this->activityLogs()->create([
            'action' => $action,
            'user_id' => $userId,
            'user_type' => $userId ? User::class : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'data' => $data,
        ]);
    }
}