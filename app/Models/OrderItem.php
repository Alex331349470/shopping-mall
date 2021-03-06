<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['amount', 'price', 'sku_id','good_id','order_id','rating', 'review', 'reviewed_at'];
    protected $dates = ['reviewed_at'];
    public $timestamps = false;

    public function good()
    {
        return $this->belongsTo(Good::class);
    }

    public function sku()
    {
        return $this->belongsTo(GoodSku::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}