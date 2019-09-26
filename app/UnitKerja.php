<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    protected $table = 'unit_kerja';
    protected $primaryKey = 'uk_id';
    protected $fillable = ['uk_nama'];
    protected $dates = ['created_at', 'updated_at'];
    public function kendaraan()
    {
        return $this->hasMany('Perjalanan');
    }
}
