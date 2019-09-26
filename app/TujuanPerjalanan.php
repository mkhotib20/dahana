<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TujuanPerjalanan extends Model
{
    protected $table = 'tujuan_perjalanan';
    protected $primaryKey = 'tp_id';
    protected $fillable = ['tp_per', 'tp_tj', 'tp_bbm', 'tp_cp', 'tp_tol'];
    protected $dates = ['created_at', 'updated_at'];
    public function tujuan()
    {
        return $this->belongsTo('Tujuan');
    }
    public function perjalanan()
    {
        return $this->belongsTo('Perjalanan');
    }
}
