<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Supplier extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'tax_id',
        'email',
        'phone',
    ];

    /**
     * Get the supplier items for this supplier.
     */
    public function supplierItems()
    {
        return $this->hasMany(SupplierItem::class);
    }

    /**
     * Get the items that this supplier offers.
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, 'supplier_items')
                    ->withPivot('supplier_sku', 'last_cost')
                    ->withTimestamps();
    }

    /**
     * Get the purchase orders for this supplier.
     */
    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
