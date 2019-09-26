<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';
    protected $primaryKey = 'kar_id';
    protected $fillable = ['kar_nama', 'kar_email', 'kar_uk'];
    protected $dates = ['created_at', 'updated_at'];
    public function perjalanan()
    {
        return $this->hasMany('Perjalanan');
    }
}
