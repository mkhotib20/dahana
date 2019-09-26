<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $primaryKey = 'dr_id';
    protected $fillable = ['dr_nama', 'dr_alamat', 'dr_hp', 'dr_stock', 'status'];
    protected $dates = ['created_at', 'updated_at'];
    public function perjalanan()
    {
        return $this->hasMany('Perjalanan');
    }
}
