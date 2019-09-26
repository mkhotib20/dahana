<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerKota extends Model
{
    protected $table = 'per_kt';
    protected $primaryKey = 'pk_id';
    protected $fillable = ['pk_per','pk_kt', 'pk_dur', 'pk_saku', 'pk_tol', 'pk_parkir', 'pk_bbm'];
    protected $dates = ['created_at', 'updated_at'];
}
