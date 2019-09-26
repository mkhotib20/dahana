<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Limit extends Model
{
    protected $table = 'limit_bul';
    protected $primaryKey = 'lim_id';
    protected $fillable = ['lim_nom'];
    protected $dates = ['created_at', 'updated_at'];
}
