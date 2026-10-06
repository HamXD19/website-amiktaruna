<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    protected $table = 'visitor_logs';

    protected $fillable = [
        'ip_address',
        'url',
        'page_name',
        'method',
        'referrer',
        'referrer_host',
        'user_agent',
        'device',
        'platform',
        'browser',
        'country',
        'country_code',
        'city',
        'session_id',
        'is_bot',
    ];

    protected $casts = [
        'is_bot' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeHuman($query)
    {
        return $query->where('is_bot', false);
    }

    public function scopeBot($query)
    {
        return $query->where('is_bot', true);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeOnline($query, int $minutes = 10)
    {
        return $query->where('created_at', '>=', now()->subMinutes($minutes));
    }

    public function getDeviceBadgeClassAttribute(): string
    {
        return match (strtolower($this->device)) {
            'mobile'  => 'badge bg-emerald-50 text-emerald-700 border border-emerald-200',
            'tablet'  => 'badge bg-cyan-50 text-cyan-700 border border-cyan-200',
            'desktop' => 'badge bg-blue-50 text-blue-700 border border-blue-200',
            default   => 'badge bg-slate-50 text-slate-700 border border-slate-200',
        };
    }

    public function getDeviceIconAttribute(): string
    {
        return match (strtolower($this->device)) {
            'mobile'  => 'fas fa-mobile-screen',
            'tablet'  => 'fas fa-tablet-screen-button',
            'desktop' => 'fas fa-laptop',
            default   => 'fas fa-robot',
        };
    }

    /**
     * Get Flag Emoji from Country Code
     */
    public function getCountryFlagAttribute(): string
    {
        if (!$this->country_code || strlen($this->country_code) !== 2) {
            return '🌐';
        }

        $code = strtoupper($this->country_code);
        if ($code === 'LO' || $code === 'XX') {
            return '🏠';
        }

        try {
            $firstChar = mb_chr(ord($code[0]) - 65 + 0x1F1E6, 'UTF-8');
            $secondChar = mb_chr(ord($code[1]) - 65 + 0x1F1E6, 'UTF-8');
            return $firstChar . $secondChar;
        } catch (\Throwable $e) {
            return '🌐';
        }
    }

    /**
     * Get Readable Location String
     */
    public function getLocationLabelAttribute(): string
    {
        if (!$this->country) {
            return 'Tidak Diketahui';
        }

        if ($this->city && $this->city !== $this->country) {
            return "{$this->city}, {$this->country}";
        }

        return $this->country;
    }
}
