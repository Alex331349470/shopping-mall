<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodSku extends Model
{
    protected $fillable = ['title', 'description', 'price', 'stock', 'good_id'];
}
