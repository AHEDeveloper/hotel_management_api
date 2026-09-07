<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmenityRoom extends Model
{
    protected $guarded = [];
    public function amenity()
    {
        return $this->belongsTo(Amenity::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
