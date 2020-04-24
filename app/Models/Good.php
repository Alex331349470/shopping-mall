<?php

namespace App\Models;

use http\Exception\BadMessageException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    protected $fillable = [
        'title','description', 'on_hot', 'on_sale','content','express_price','price', 'rating',
        'category_id','good_no', 'stock','sold_count', 'review_count'
        ];

    protected $casts = [
        'on_sale' => 'boolean', // on_sale 是一个布尔类型的字段
        'on_hot' => 'boolean'
    ];
    // 与商品SKU关联
    public function images()
    {
        return $this->hasMany(GoodImage::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
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
