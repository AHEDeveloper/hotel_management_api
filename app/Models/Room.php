<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = [];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

}
