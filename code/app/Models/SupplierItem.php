<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SupplierItem extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'supplier_id',
        'item_id',
        'supplier_sku',
        'last_cost',
    ];

    protected $casts = [
        'last_cost' => 'decimal:4',
    ];

    /**
     * Get the supplier for this supplier item.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the item for this supplier item.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
