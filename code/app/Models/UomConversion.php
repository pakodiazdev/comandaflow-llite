<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class UomConversion extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'from_uom_id',
        'to_uom_id',
        'factor',
    ];

    protected $casts = [
        'factor' => 'decimal:4',
    ];

    /**
     * Get the source UOM.
     */
    public function fromUom()
    {
        return $this->belongsTo(Uom::class, 'from_uom_id');
    }

    /**
     * Get the target UOM.
     */
    public function toUom()
    {
        return $this->belongsTo(Uom::class, 'to_uom_id');
    }
}
