<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
    //

    protected $fillable = [
        'invitation_id',
        'nama_tamu',
        'status_kehadiran',
        'jumlah_kehadiran',
        'pesan',
        "guest_token"
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rsvplikes()
    {
        return $this->hasMany(Rsvplike::class);
    }

    public function rsvpreplies()
    {
        return $this->hasMany(Rsvpreply::class);
    }
}
