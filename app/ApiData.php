<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiData extends Model
{
    protected $fillable = ['activity', 'activityType', 'country', 'fuelType', 'mode', 'carbonFootprint'];
}
