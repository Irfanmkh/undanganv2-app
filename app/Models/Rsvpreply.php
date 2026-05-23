<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rsvpreply extends Model
{
    //

    protected $fillable = [
        'user_id',
        'rsvp_id',
        'nama_pembalas',
        'guest_token',
        'pesan_reply',
        'like_count'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rsvp()
    {
        return $this->belongsTo(Rsvp::class);
    }

    public function rsvpreplylikes()
    {
        return $this->hasMany(Rsvpreplylike::class);
    }
}
