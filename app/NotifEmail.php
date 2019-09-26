<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotifEmail extends Model
{
    protected $table = 'notif_email';
    protected $primaryKey = 'id';
    protected $fillable = ['email'];
    protected $dates = ['created_at', 'updated_at'];
}
