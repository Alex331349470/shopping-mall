<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['amount'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function good()
    {
        return $this->belongsTo(Good::class);
    }

    public function sku()
    {
        return $this->belongsTo(GoodSku::class);
    }
}
