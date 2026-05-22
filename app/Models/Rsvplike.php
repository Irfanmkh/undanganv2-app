<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rsvplike extends Model
{
    //
    protected $fillable = [
        'rsvp_id',
        'guest_token'
    ];

    public function rsvp()
    {
        return $this->belongsTo(Rsvp::class);
    }
}
