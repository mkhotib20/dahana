<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tujuan extends Model
{
    protected $table = 'tujuan';
    protected $primaryKey = 'tj_id';
    protected $fillable = ['tj_kota_1', 'tj_jarak', 'tj_kota_2', 'tj_tol'];
    protected $dates = ['created_at', 'updated_at'];
    public function kota()
    {
        return $this->belongsTo('Kota');
    }
    public function tujuan_perjalanan()
    {
        return $this->hasMany('TujuanPerjalanan');
    }
}
