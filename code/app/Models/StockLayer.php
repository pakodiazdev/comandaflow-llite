<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class StockLayer extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'item_variant_id',
        'location_id',
        'lot_id',
        'qty_in',
        'qty_out',
        'unit_cost',
        'received_at',
        'expiry_at',
    ];

    protected $casts = [
        'qty_in' => 'decimal:4',
        'qty_out' => 'decimal:4',
        'unit_cost' => 'decimal:4',
        'received_at' => 'datetime',
        'expiry_at' => 'datetime',
    ];

    /**
     * Get the item variant for this stock layer.
     */
    public function itemVariant()
    {
        return $this->belongsTo(ItemVariant::class);
    }

    /**
     * Get the location for this stock layer.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the lot for this stock layer.
     */
    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }

    /**
     * Get the available quantity (qty_in - qty_out).
     */
    public function getAvailableQtyAttribute()
    {
        return $this->qty_in - $this->qty_out;
    }

    /**
     * Scope to filter by available stock.
     */
    public function scopeWithStock($query)
    {
        return $query->whereColumn('qty_in', '>', 'qty_out');
    }
}
