<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Location extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'code',
        'name',
    ];

    /**
     * Get the stock layers for this location.
     */
    public function stockLayers()
    {
        return $this->hasMany(StockLayer::class);
    }

    /**
     * Get the stock moves from this location.
     */
    public function stockMovesFrom()
    {
        return $this->hasMany(StockMove::class, 'location_from_id');
    }

    /**
     * Get the stock moves to this location.
     */
    public function stockMovesTo()
    {
        return $this->hasMany(StockMove::class, 'location_to_id');
    }
}
