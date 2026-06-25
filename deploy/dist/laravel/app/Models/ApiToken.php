<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApiToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'dealer_id',
        'name',
        'token',
        'last_used_at',
        'expires_at',
    ];

    protected $casts = [
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    protected $hidden = [
        'token',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($token) {
            if (empty($token->token)) {
                $token->token = static::generateToken();
            }
        });
    }

    /**
     * Generate a unique API token.
     */
    protected static function generateToken()
    {
        do {
            $token = Str::random(64);
        } while (static::where('token', $token)->exists());

        return hash('sha256', $token);
    }

    /**
     * Get the dealer that owns the API token.
     */
    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }

    /**
     * Get the activity logs for the API token.
     */
    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    /**
     * Scope a query to only include active tokens.
     */
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
                ->orWhere('expires_at', '>', now());
        });
    }

    /**
     * Scope a query to only include expired tokens.
     */
    public function scopeExpired($query)
    {
        return $query->whereNotNull('expires_at')
            ->where('expires_at', '<=', now());
    }

    /**
     * Check if the token is active.
     */
    public function isActive()
    {
        return is_null($this->expires_at) || $this->expires_at->isFuture();
    }

    /**
     * Check if the token has expired.
     */
    public function hasExpired()
    {
        return !is_null($this->expires_at) && $this->expires_at->isPast();
    }

    /**
     * Touch the last used timestamp.
     */
    public function touchLastUsed()
    {
        $this->update(['last_used_at' => now()]);
    }

    /**
     * Revoke the token by setting expiration to now.
     */
    public function revoke()
    {
        $this->update(['expires_at' => now()]);
        
        $this->logActivity('revoked');
    }

    /**
     * Find token by the actual token value.
     */
    public static function findByToken($token)
    {
        return static::where('token', hash('sha256', $token))
            ->active()
            ->first();
    }

    /**
     * Validate token and check dealer access.
     */
    public function validateAccess()
    {
        if ($this->hasExpired()) {
            return false;
        }

        if (!$this->dealer) {
            return false;
        }

        if (!$this->dealer->is_active || !$this->dealer->api_access) {
            return false;
        }

        $this->touchLastUsed();
        
        return true;
    }

    /**
     * Get the days until expiration.
     */
    public function getDaysUntilExpirationAttribute()
    {
        if (is_null($this->expires_at)) {
            return null;
        }

        if ($this->hasExpired()) {
            return 0;
        }

        return now()->diffInDays($this->expires_at, false);
    }

    /**
     * Get the masked token for display.
     */
    public function getMaskedTokenAttribute()
    {
        // Since token is hashed, we can't show the original
        // Show first and last few characters of the hash
        $hash = $this->token;
        if (strlen($hash) > 12) {
            return substr($hash, 0, 6) . '...' . substr($hash, -6);
        }
        
        return $hash;
    }

    /**
     * Log activity for the API token.
     */
    protected function logActivity($action, $data = [])
    {
        $this->activityLogs()->create([
            'action' => $action,
            'user_id' => null,
            'user_type' => null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'data' => $data,
        ]);
    }
}