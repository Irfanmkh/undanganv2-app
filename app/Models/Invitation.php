<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    //

    protected $fillable = [
        'user_id',
        'slug',
        'fullname_pria',
        'nickname_pria',
        'fullname_wanita',
        'nickname_wanita',
        'ayah_pria',
        'ibu_pria',
        'ayah_wanita',
        'ibu_wanita',
        'tema',
        'waktu_resepsi',
        'waktu_akad',
        'lokasi_akad',
        'lokasi_resepsi',
        'link_map_akad',
        'link_map_resepsi'
    ];


    // relation

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
