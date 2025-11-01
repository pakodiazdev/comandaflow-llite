<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Asset extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'item_id',
        'serial',
        'acquisition_cost',
        'acquisition_date',
        'useful_life_months',
        'salvage_value',
        'depreciation_method',
        'status',
    ];

    protected $casts = [
        'acquisition_cost' => 'decimal:2',
        'acquisition_date' => 'date',
        'salvage_value' => 'decimal:2',
    ];

    /**
     * Get the item for this asset.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the depreciation records for this asset.
     */
    public function depreciations()
    {
        return $this->hasMany(AssetDepreciation::class);
    }

    /**
     * Calculate monthly depreciation amount.
     */
    public function getMonthlyDepreciationAttribute()
    {
        if ($this->useful_life_months <= 0) {
            return 0;
        }
        
        return ($this->acquisition_cost - $this->salvage_value) / $this->useful_life_months;
    }

    /**
     * Get total depreciation posted.
     */
    public function getTotalDepreciationAttribute()
    {
        return $this->depreciations()->where('posted', true)->sum('amount');
    }

    /**
     * Get current book value.
     */
    public function getBookValueAttribute()
    {
        return $this->acquisition_cost - $this->total_depreciation;
    }

    /**
     * Scope to filter by status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
