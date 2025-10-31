<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_person',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'tax_id',
        'website',
        'notes',
        'status',
        'credit_limit',
        'payment_terms',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'payment_terms' => 'integer',
    ];

    /**
     * Get the products that this supplier provides.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_suppliers')
                    ->withPivot(['price', 'lead_time_days', 'minimum_quantity', 'is_preferred'])
                    ->withTimestamps();
    }

    /**
     * Scope a query to only include active suppliers.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive suppliers.
     */
    public function scopeInactive(Builder $query): void
    {
        $query->where('status', 'inactive');
    }

    /**
     * Get the supplier's full address.
     */
    public function getFullAddressAttribute(): string
    {
        $address = [];
        
        if ($this->address) $address[] = $this->address;
        if ($this->city) $address[] = $this->city;
        if ($this->state) $address[] = $this->state;
        if ($this->postal_code) $address[] = $this->postal_code;
        if ($this->country) $address[] = $this->country;
        
        return implode(', ', $address);
    }

    /**
     * Get the supplier's status badge class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'active' => 'bg-green-100 text-green-800',
            'inactive' => 'bg-gray-100 text-gray-800',
            'suspended' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}
