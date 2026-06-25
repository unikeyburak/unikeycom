<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dealer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_name',
        'tax_number',
        'tax_office',
        'phone',
        'email',
        'website',
        'address',
        'city',
        'district',
        'postal_code',
        'latitude',
        'longitude',
        'logo',
        'about',
        'working_hours',
        'social_media',
        'status',
        'approved_at',
        'approved_by',
        'suspension_reason',
        'suspended_at',
        
        // Yeni eklenenler (opsiyonel)
        'contact_name',
        'whatsapp',
        'is_active',
        'is_verified',
        'credit_limit',
        'payment_terms',
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
        'credit_limit' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'working_hours' => 'array',
        'social_media' => 'array',
        'approved_at' => 'datetime',
        'suspended_at' => 'datetime',
    ];

    protected $hidden = [
        'notes',
    ];

    /**
     * Get the dealer users for the dealer.
     */
    public function dealerUsers()
    {
        return $this->hasMany(DealerUser::class);
    }

    /**
     * Get the orders for the dealer.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the invoices for the dealer.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the API tokens for the dealer.
     */
    public function apiTokens()
    {
        return $this->hasMany(ApiToken::class);
    }

    /**
     * Get the activity logs for the dealer.
     */
    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    /**
     * Scope a query to only include active dealers.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include verified dealers.
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope a query to only include dealers with API access.
     */
    public function scopeWithApiAccess($query)
    {
        return $query->where('api_access', true);
    }

    /**
     * Get the logo URL.
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    /**
     * Get the full address.
     */
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->address,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country,
        ]);

        return implode(', ', $parts);
    }

    /**
     * Check if the dealer has reached their credit limit.
     */
    public function hasReachedCreditLimit()
    {
        if (!$this->credit_limit) {
            return false;
        }

        $outstandingAmount = $this->invoices()
            ->whereIn('status', ['pending', 'overdue'])
            ->sum('total_amount');

        return $outstandingAmount >= $this->credit_limit;
    }

    /**
     * Get the available credit.
     */
    public function getAvailableCreditAttribute()
    {
        if (!$this->credit_limit) {
            return null;
        }

        $outstandingAmount = $this->invoices()
            ->whereIn('status', ['pending', 'overdue'])
            ->sum('total_amount');

        return max(0, $this->credit_limit - $outstandingAmount);
    }

    /**
     * Generate a new API token for the dealer.
     */
    public function generateApiToken($name = 'Default', $expiresAt = null)
    {
        return $this->apiTokens()->create([
            'name' => $name,
            'token' => bin2hex(random_bytes(32)),
            'expires_at' => $expiresAt,
        ]);
    }
}