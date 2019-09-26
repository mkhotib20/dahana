<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bbm extends Model
{
    protected $table = 'bbm';
    protected $primaryKey = 'bbm_id';
    protected $fillable = ['bbm_nama', 'bbm_harga'];
    protected $dates = ['created_at', 'updated_at'];
    public function kendaraan()
    {
        return $this->hasMany('Kendaraan');
    }
}
