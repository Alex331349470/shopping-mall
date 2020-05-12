<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodSku extends Model
{
    protected $fillable = ['title', 'description', 'price', 'stock', 'good_id'];

    public function good()
    {
        return $this->belongsTo(Good::class);
    }

    public function decreaseStock($amount)
    {
        if ($amount < 0) {
            abort(403,'减库存不可小于0');
        }

        return $this->where('id', $this->id)->where('stock', '>=', $amount)->decrement('stock', $amount);
    }

    public function addStock($amount)
    {
        if ($amount < 0) {
            abort(403,'加库存不可小于0');
        }
        $this->increment('stock', $amount);
    }
}
