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

    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'id', 'left');
    }

    public function info() {
        return $this->hasOne(UserInfo::class, 'user_id', 'user_id');
    }

    public function getNewUserTypeAttribute() {
        switch ($this->user_type) {
            case '0':
                return '普通客户';
            case '1':
                return '二级代销';
            case '2':
                return '一级代销';
            default:
                return '未知异常';
        }
    }

}
