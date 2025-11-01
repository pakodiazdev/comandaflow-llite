<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Item extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'sku',
        'name',
        'type',
        'is_stocked',
        'is_perishable',
        'default_uom_id',
        'has_variants',
        'selling_price',
        'notes',
    ];

    protected $casts = [
        'is_stocked' => 'boolean',
        'is_perishable' => 'boolean',
        'has_variants' => 'boolean',
        'selling_price' => 'decimal:2',
    ];

    /**
     * Get the default UOM for this item.
     */
    public function defaultUom()
    {
        return $this->belongsTo(Uom::class, 'default_uom_id');
    }

    /**
     * Get the item variants for this item.
     */
    public function variants()
    {
        return $this->hasMany(ItemVariant::class);
    }

    /**
     * Get the supplier items for this item.
     */
    public function supplierItems()
    {
        return $this->hasMany(SupplierItem::class);
    }

    /**
     * Get the suppliers that offer this item.
     */
    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'supplier_items')
                    ->withPivot('supplier_sku', 'last_cost')
                    ->withTimestamps();
    }

    /**
     * Get the assets for this item (if item type is ACTIVO).
     */
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    /**
     * Get the BOMs where this item is the product.
     */
    public function boms()
    {
        return $this->hasMany(Bom::class);
    }

    /**
     * Scope to filter by type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to filter stocked items.
     */
    public function scopeStocked($query)
    {
        return $query->where('is_stocked', true);
    }

    /**
     * Scope to filter perishable items.
     */
    public function scopePerishable($query)
    {
        return $query->where('is_perishable', true);
    }
}
