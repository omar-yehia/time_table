<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $fillable=[
'user_id',
'pharmacy_id',
'date',
'day',
'start_time',
'end_time',
    ];
}
