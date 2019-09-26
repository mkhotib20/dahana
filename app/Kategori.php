<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'kat_id';
    protected $fillable = ['kat_nama', 'kat_cc', 'kat_kons'];
    protected $dates = ['created_at', 'updated_at'];
    public function kendaraan()
    {
        return $this->hasMany('Kendaraan');
    }
}
