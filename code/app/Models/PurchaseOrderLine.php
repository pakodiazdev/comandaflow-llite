<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PurchaseOrderLine extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'purchase_order_id',
        'item_variant_id',
        'qty',
        'unit_cost',
    ];

    protected $casts = [
        'qty' => 'decimal:4',
        'unit_cost' => 'decimal:4',
    ];

    /**
     * Get the purchase order for this line.
     */
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    /**
     * Get the item variant for this line.
     */
    public function itemVariant()
    {
        return $this->belongsTo(ItemVariant::class);
    }

    /**
     * Get the total cost for this line.
     */
    public function getTotalCostAttribute()
    {
        return $this->qty * $this->unit_cost;
    }
}
