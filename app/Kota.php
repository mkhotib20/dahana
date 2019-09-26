<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $table = 'kota';
    protected $primaryKey = 'kt_id';
    protected $fillable = ['kt_nama', 'kt_tol', 'kt_parkir'];
    protected $dates = ['created_at', 'updated_at'];
    public function tujuan()
    {
        return $this->hasMany('Tujuan');
    }
}
