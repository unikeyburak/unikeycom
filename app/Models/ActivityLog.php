<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'loggable_type',
        'loggable_id',
        'action',
        'user_id',
        'user_type',
        'ip_address',
        'user_agent',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Get the parent loggable model.
     */
    public function loggable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user that performed the action.
     */
    public function user()
    {
        return $this->morphTo('user');
    }

    /**
     * Scope a query to filter by action.
     */
    public function scopeAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope a query to filter by loggable type.
     */
    public function scopeForType($query, $type)
    {
        return $query->where('loggable_type', $type);
    }

    /**
     * Scope a query to filter by loggable model.
     */
    public function scopeForModel($query, $model)
    {
        return $query->where('loggable_type', get_class($model))
            ->where('loggable_id', $model->id);
    }

    /**
     * Scope a query to filter by user.
     */
    public function scopeByUser($query, $user)
    {
        return $query->where('user_type', get_class($user))
            ->where('user_id', $user->id);
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope a query to get recent activities.
     */
    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * Get the user display name.
     */
    public function getUserNameAttribute()
    {
        if (!$this->user) {
            return 'System';
        }

        if ($this->user instanceof User) {
            return $this->user->name;
        }

        if ($this->user instanceof DealerUser) {
            return $this->user->name . ' (Dealer)';
        }

        return 'Unknown';
    }

    /**
     * Get the loggable display name.
     */
    public function getLoggableNameAttribute()
    {
        if (!$this->loggable) {
            return 'Deleted Record';
        }

        $class = class_basename($this->loggable_type);
        
        switch ($class) {
            case 'Product':
                return $this->loggable->name;
            case 'Category':
                return $this->loggable->name;
            case 'Order':
                return 'Order #' . $this->loggable->order_number;
            case 'Invoice':
                return 'Invoice #' . $this->loggable->invoice_number;
            case 'Dealer':
                return $this->loggable->company_name;
            case 'DealerUser':
                return $this->loggable->name;
            case 'Page':
                return $this->loggable->title;
            case 'ApiToken':
                return 'API Token: ' . $this->loggable->name;
            default:
                return $class . ' #' . $this->loggable_id;
        }
    }

    /**
     * Get a human-readable description of the activity.
     */
    public function getDescriptionAttribute()
    {
        $userName = $this->user_name;
        $loggableName = $this->loggable_name;
        
        switch ($this->action) {
            case 'created':
                return "{$userName} created {$loggableName}";
            case 'updated':
                return "{$userName} updated {$loggableName}";
            case 'deleted':
                return "{$userName} deleted {$loggableName}";
            case 'restored':
                return "{$userName} restored {$loggableName}";
            case 'viewed':
                return "{$userName} viewed {$loggableName}";
            case 'approved':
                return "{$userName} approved {$loggableName}";
            case 'rejected':
                $reason = $this->data['reason'] ?? 'No reason provided';
                return "{$userName} rejected {$loggableName}: {$reason}";
            case 'invoiced':
                return "{$loggableName} was invoiced";
            case 'paid':
                $method = $this->data['payment_method'] ?? 'Unknown method';
                return "{$loggableName} was paid via {$method}";
            case 'cancelled':
                $reason = $this->data['reason'] ?? 'No reason provided';
                return "{$userName} cancelled {$loggableName}: {$reason}";
            case 'marked_overdue':
                return "{$loggableName} was marked as overdue";
            case 'revoked':
                return "{$loggableName} was revoked";
            case 'login':
                return "{$userName} logged in";
            case 'logout':
                return "{$userName} logged out";
            case 'failed_login':
                return "Failed login attempt for {$this->data['email'] ?? 'unknown email'}";
            default:
                return "{$userName} performed {$this->action} on {$loggableName}";
        }
    }

    /**
     * Get browser name from user agent.
     */
    public function getBrowserAttribute()
    {
        if (!$this->user_agent) {
            return 'Unknown';
        }

        $browsers = [
            'Chrome' => 'Chrome',
            'Firefox' => 'Firefox',
            'Safari' => 'Safari',
            'Edge' => 'Edge',
            'Opera' => 'Opera',
            'MSIE' => 'Internet Explorer',
            'Trident' => 'Internet Explorer',
        ];

        foreach ($browsers as $key => $name) {
            if (str_contains($this->user_agent, $key)) {
                return $name;
            }
        }

        return 'Other';
    }

    /**
     * Get device type from user agent.
     */
    public function getDeviceTypeAttribute()
    {
        if (!$this->user_agent) {
            return 'Unknown';
        }

        $userAgent = strtolower($this->user_agent);

        if (str_contains($userAgent, 'mobile') || str_contains($userAgent, 'android')) {
            return 'Mobile';
        }

        if (str_contains($userAgent, 'tablet') || str_contains($userAgent, 'ipad')) {
            return 'Tablet';
        }

        return 'Desktop';
    }

    /**
     * Log a new activity.
     */
    public static function log($loggable, $action, $user = null, $data = [])
    {
        return static::create([
            'loggable_type' => get_class($loggable),
            'loggable_id' => $loggable->id,
            'action' => $action,
            'user_id' => $user ? $user->id : null,
            'user_type' => $user ? get_class($user) : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'data' => $data,
        ]);
    }
}