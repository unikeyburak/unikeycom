<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class DealerUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'dealer_id',
        'name',
        'email',
        'password',
        'phone',
        'mobile',
        'role',
        'is_active',
        'last_login_at',
        'last_login_ip',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the dealer that owns the dealer user.
     */
    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }

    /**
     * Get the orders created by this dealer user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'created_by');
    }

    /**
     * Get the activity logs for the dealer user.
     */
    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    /**
     * Get the activity logs created by this dealer user.
     */
    public function createdActivityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'user_id');
    }

    /**
     * Scope a query to only include active dealer users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if the dealer user has a specific role.
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Check if the dealer user is an admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the dealer user is a manager.
     */
    public function isManager()
    {
        return in_array($this->role, ['admin', 'manager']);
    }

    /**
     * Update the last login timestamp.
     */
    public function updateLastLogin()
    {
        $this->update(['last_login_at' => now()]);
    }

    /**
     * Get the full name with dealer.
     */
    public function getFullIdentificationAttribute()
    {
        return $this->name . ' (' . $this->dealer->company_name . ')';
    }

    /**
     * Check if the user can access API.
     */
    public function canAccessApi()
    {
        return $this->is_active && 
               $this->dealer->is_active && 
               $this->dealer->api_access;
    }

    /**
     * Check if the user can place orders.
     */
    public function canPlaceOrders()
    {
        return $this->is_active && 
               $this->dealer->is_active && 
               $this->dealer->is_verified &&
               !$this->dealer->hasReachedCreditLimit();
    }

    /**
     * Get the API rate limit for this user.
     */
    public function getApiRateLimitAttribute()
    {
        return $this->dealer->api_rate_limit ?? 60;
    }
}