<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    //
    protected $fillable = [
        "nama_tema",
        "is_premium",
        "preview",
        "slug"
    ];

    public function invitation(){
        return $this->hasMany(Invitation::class);

    }
}

