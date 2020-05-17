<?php

namespace App\Models;

use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $fillable = ['user_id','parent_id','real_name', 'type','gender'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
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

    public function getAllChildrenIdById($parent_id, $is_first_level) {
        if ($is_first_level) {
            $user_info_arr = $this->newQuery()
                ->where('parent_id', $parent_id)
                ->where('type', 1)
                ->get(['user_id']);
            if ($user_info_arr) {
                $id_arr = array_column($user_info_arr->toArray(), 'user_id');
            } else {
                $id_arr = [];
            }
        } else {
            $id_arr = [$parent_id];
        }

        array_push($id_arr, $parent_id);
        return $id_arr;
    }
}
