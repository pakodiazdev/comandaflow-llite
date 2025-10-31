<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'description',
        'category',
        'unit_of_measure',
        'current_stock',
        'minimum_stock',
        'maximum_stock',
        'cost_price',
        'selling_price',
        'barcode',
        'is_perishable',
        'shelf_life_days',
        'status',
        'notes',
    ];

    protected $casts = [
        'current_stock' => 'decimal:2',
        'minimum_stock' => 'decimal:2',
        'maximum_stock' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'is_perishable' => 'boolean',
        'shelf_life_days' => 'integer',
    ];

    /**
     * Get the suppliers that provide this product.
     */
    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class, 'product_suppliers')
                    ->withPivot(['price', 'lead_time_days', 'minimum_quantity', 'is_preferred'])
                    ->withTimestamps();
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 'active');
    }

    /**
     * Scope a query to only include low stock products.
     */
    public function scopeLowStock(Builder $query): void
    {
        $query->whereColumn('current_stock', '<=', 'minimum_stock');
    }

    /**
     * Check if product is low on stock.
     */
    public function getIsLowStockAttribute(): bool
    {
        return $this->current_stock <= $this->minimum_stock;
    }

    /**
     * Get the product's status badge class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'active' => 'bg-green-100 text-green-800',
            'inactive' => 'bg-gray-100 text-gray-800',
            'discontinued' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Get the stock status badge class.
     */
    public function getStockStatusBadgeClassAttribute(): string
    {
        if ($this->is_low_stock) {
            return 'bg-red-100 text-red-800';
        }
        
        if ($this->current_stock == 0) {
            return 'bg-red-100 text-red-800';
        }
        
        return 'bg-green-100 text-green-800';
    }
}
