<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $fillable = ['user_id','parent_id','real_name', 'type','gender'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id', 'left');
    }

    public function getNewTypeAttribute(){
        switch ($this->type) {
            case '1':
                return '二级代理';
            case '2':
                return '一级代理';
            default:
                return '普通用户';
        }
    }

    public function getNewGenderAttribute(){
        switch ($this->gender) {
            case '1':
                return '男';
            case '2':
                return '女';
            default:
                return '保密';
        }
    }
}
