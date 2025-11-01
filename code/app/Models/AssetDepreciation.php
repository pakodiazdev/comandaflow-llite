<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AssetDepreciation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'asset_id',
        'period',
        'amount',
        'posted',
    ];

    protected $casts = [
        'period' => 'date',
        'amount' => 'decimal:2',
        'posted' => 'boolean',
    ];

    /**
     * Get the asset for this depreciation.
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    /**
     * Scope to filter posted depreciations.
     */
    public function scopePosted($query)
    {
        return $query->where('posted', true);
    }

    /**
     * Scope to filter unposted depreciations.
     */
    public function scopeUnposted($query)
    {
        return $query->where('posted', false);
    }
}
