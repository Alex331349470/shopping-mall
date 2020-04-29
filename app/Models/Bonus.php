<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    protected $fillable = ['user_id', 'order_id','user_type', 'bonus'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
