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
        'jumlah_kehadiran'
    ];
}
