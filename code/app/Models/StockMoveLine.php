<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class StockMoveLine extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'stock_move_id',
        'item_variant_id',
        'lot_id',
        'qty',
        'unit_cost',
    ];

    protected $casts = [
        'qty' => 'decimal:4',
        'unit_cost' => 'decimal:4',
    ];

    /**
     * Get the stock move for this line.
     */
    public function stockMove()
    {
        return $this->belongsTo(StockMove::class);
    }

    /**
     * Get the item variant for this line.
     */
    public function itemVariant()
    {
        return $this->belongsTo(ItemVariant::class);
    }

    /**
     * Get the lot for this line.
     */
    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }

    /**
     * Get the total cost for this line.
     */
    public function getTotalCostAttribute()
    {
        return $this->qty * $this->unit_cost;
    }
}
