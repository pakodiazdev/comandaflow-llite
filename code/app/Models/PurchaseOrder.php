<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PurchaseOrder extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'supplier_id',
        'status',
        'eta',
    ];

    protected $casts = [
        'eta' => 'datetime',
    ];

    /**
     * Get the supplier for this purchase order.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the purchase order lines for this order.
     */
    public function lines()
    {
        return $this->hasMany(PurchaseOrderLine::class);
    }

    /**
     * Scope to filter by status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get the total amount for this purchase order.
     */
    public function getTotalAmountAttribute()
    {
        return $this->lines->sum(function ($line) {
            return $line->qty * $line->unit_cost;
        });
    }
}
