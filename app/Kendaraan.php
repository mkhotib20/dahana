<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $table = 'kendaraan';
    protected $primaryKey = 'ken_id';
    protected $fillable = ['ken_merk', 'ken_kat', 'ken_kons', 'ken_bbm', 'ken_nopol', 'ken_stock'];
    protected $dates = ['created_at', 'updated_at'];
    public function kategori()
    {
        return $this->belongsTo('App\Kategori');
    }
    public function bbm()
    {
        return $this->belongsTo('Bbm');
    }
    public function perjalanan()
    {
        return $this->hasMany('Perjalanan');
    }
}
