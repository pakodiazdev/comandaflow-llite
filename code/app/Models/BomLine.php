<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BomLine extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'bom_id',
        'component_item_variant_id',
        'component_qty',
        'component_uom_id',
    ];

    protected $casts = [
        'component_qty' => 'decimal:4',
    ];

    /**
     * Get the BOM for this line.
     */
    public function bom()
    {
        return $this->belongsTo(Bom::class);
    }

    /**
     * Get the component item variant for this line.
     */
    public function componentItemVariant()
    {
        return $this->belongsTo(ItemVariant::class, 'component_item_variant_id');
    }

    /**
     * Get the component UOM for this line.
     */
    public function componentUom()
    {
        return $this->belongsTo(Uom::class, 'component_uom_id');
    }
}
