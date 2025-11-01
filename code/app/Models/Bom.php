<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Bom extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'item_id',
        'yield_qty',
        'uom_id',
    ];

    protected $casts = [
        'yield_qty' => 'decimal:4',
    ];

    /**
     * Get the item (product) for this BOM.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the UOM for the yield quantity.
     */
    public function uom()
    {
        return $this->belongsTo(Uom::class);
    }

    /**
     * Get the BOM lines (components) for this BOM.
     */
    public function lines()
    {
        return $this->hasMany(BomLine::class);
    }

    /**
     * Calculate the total cost of components for this BOM.
     */
    public function getTotalComponentCostAttribute()
    {
        return $this->lines->sum(function ($line) {
            // This would need to get the current cost of each component
            // For now, just return a placeholder
            return 0;
        });
    }
}
