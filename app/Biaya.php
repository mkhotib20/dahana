<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Biaya extends Model
{
    protected $table = 'biaya';
    protected $primaryKey = 'b_id';
    protected $fillable = ['b_tp','b_nama', 'b_nominal'];
    protected $dates = ['created_at', 'updated_at'];
    public function perjalanan()
    {
        return $this->belongsTo('Perjalanan');
    }
}
