<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rsvpreplylike extends Model
{
    //
    protected $fillable = [
        'rsvpreply_id',
        'guest_token'
    ];

    public function rsvpreply()
    {
        return $this->belongsTo(Rsvpreply::class);
    }
}
