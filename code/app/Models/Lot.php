<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Lot extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'lot_code',
        'manufactured_at',
        'expiry_at',
    ];

    protected $casts = [
        'manufactured_at' => 'datetime',
        'expiry_at' => 'datetime',
    ];

    /**
     * Get the stock layers for this lot.
     */
    public function stockLayers()
    {
        return $this->hasMany(StockLayer::class);
    }

    /**
     * Get the stock move lines for this lot.
     */
    public function stockMoveLines()
    {
        return $this->hasMany(StockMoveLine::class);
    }

    /**
     * Scope to filter expired lots.
     */
    public function scopeExpired($query)
    {
        return $query->where('expiry_at', '<', now());
    }

    /**
     * Scope to filter lots expiring soon.
     */
    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->where('expiry_at', '<=', now()->addDays($days))
                     ->where('expiry_at', '>', now());
    }
}
