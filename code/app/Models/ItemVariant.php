<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ItemVariant extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'item_id',
        'code',
        'name',
        'uom_id',
        'track_lot',
        'track_serial',
    ];

    protected $casts = [
        'track_lot' => 'boolean',
        'track_serial' => 'boolean',
    ];

    /**
     * Get the item that owns this variant.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the UOM for this variant.
     */
    public function uom()
    {
        return $this->belongsTo(Uom::class);
    }

    /**
     * Get the stock layers for this variant.
     */
    public function stockLayers()
    {
        return $this->hasMany(StockLayer::class);
    }

    /**
     * Get the stock move lines for this variant.
     */
    public function stockMoveLines()
    {
        return $this->hasMany(StockMoveLine::class);
    }

    /**
     * Get the purchase order lines for this variant.
     */
    public function purchaseOrderLines()
    {
        return $this->hasMany(PurchaseOrderLine::class);
    }

    /**
     * Get the BOM lines where this variant is a component.
     */
    public function bomLines()
    {
        return $this->hasMany(BomLine::class, 'component_item_variant_id');
    }
}
