<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class StockMove extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'type',
        'location_from_id',
        'location_to_id',
        'moved_at',
        'ref_doc_id',
        'ref_doc_type',
        'note',
    ];

    protected $casts = [
        'moved_at' => 'datetime',
    ];

    /**
     * Get the source location for this move.
     */
    public function locationFrom()
    {
        return $this->belongsTo(Location::class, 'location_from_id');
    }

    /**
     * Get the destination location for this move.
     */
    public function locationTo()
    {
        return $this->belongsTo(Location::class, 'location_to_id');
    }

    /**
     * Get the stock move lines for this move.
     */
    public function lines()
    {
        return $this->hasMany(StockMoveLine::class);
    }

    /**
     * Scope to filter by move type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
