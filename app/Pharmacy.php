<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    protected $fillable=['name'];
    public function times()
    {
        return $this->hasMany(Time::class);
    }
}
