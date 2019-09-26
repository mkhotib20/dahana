<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perjalanan extends Model
{
    protected $table = 'perjalanan';
    protected $primaryKey = 'per_id';
    protected $fillable = ['per_km_start','per_km_end','per_kep','per_pengembalian','per_status', 'per_id','per_no', 'per_jam', 'per_biaya', 'per_karyawan', 'per_pengaju', 'per_tgl_start', 'per_mobil', 'per_driver', 'per_tujuan'];
    protected $dates = ['created_at', 'updated_at'];
    public function driver()
    {
        return $this->belongsTo('Driver');
    }
    public function kendaraan()
    {
        return $this->belongsTo('Kendaraan');
    }
    public function unitKerja()
    {
        return $this->belongsTo('UnitKerja');
    }
    public function biaya()
    {
        return $this->hasMany('Biaya');
    }
    public function tujuan_perjalanan()
    {
        return $this->hasMany('TujuanPerjalanan');
    }
}
