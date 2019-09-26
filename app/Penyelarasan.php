<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penyelarasan extends Model
{
    
    protected $table = 'penyelarasan';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_biaya', 'nominal', 'pen_per'];
    protected $dates = ['created_at', 'updated_at'];
}
