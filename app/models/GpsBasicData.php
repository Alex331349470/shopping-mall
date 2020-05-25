<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class GpsBasicData extends Model
{
    protected $fillable = ['user_id', 'area_num', 'project_code', 'gps_basic_data'];
}
