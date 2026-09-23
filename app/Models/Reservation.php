<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservationRoom()
    {
        return $this->hasMany(ReservationRoom::class);
    }

    public function olderThen(int $minutes) : bool
    {
        return $this->updated_at->diffInMinutes(now()) > $minutes;
    }

    public function cancel()
    {
        return $this->update(['status' => 'cancelled']);
    }
}
