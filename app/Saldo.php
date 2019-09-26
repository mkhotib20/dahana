<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    protected $table = 'saldo';
    protected $primaryKey = 'id';
    protected $fillable = ['nominal', 'label'];
    protected $dates = ['created_at', 'updated_at'];
}
