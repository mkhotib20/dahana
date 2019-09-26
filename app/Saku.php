<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saku extends Model
{
    protected $table = 'saku';
    protected $primaryKey = 'id';
    protected $fillable = ['saku'];
    protected $dates = ['created_at', 'updated_at'];
}
