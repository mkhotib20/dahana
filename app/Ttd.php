<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ttd extends Model
{
    protected $table = 'ttd';
    protected $primaryKey = 'id';
    protected $fillable = ['nama', 'jabatan'];
    protected $dates = ['created_at', 'updated_at'];
}
