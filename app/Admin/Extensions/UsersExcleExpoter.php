<?php
namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExcleExpoter extends ExcelExporter implements WithMapping {
    protected $fileName = '会员信息管理.xlsx';

    protected $headings = [
        'id'      => 'ID',
        'name'   => '微信昵称',
        'phone' => '手机号',
        'sub' => '是否订阅',
        'gender' => '性别',
        'user_type' => '用户类型',
        'created_at' => '创建时间',
    ];


    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($user): array
    {
        $gender_arr = config('admin.gender');
        $gender = isset($gender_arr[$user->gender])?$gender_arr[$user->gender]:'未知';
        $user_type = config('admin.user_type');
        $type = isset($user_type[$user->type])?$user_type[$user->type]:'未知';
        return [
            $user->id,
            $user->name,
            $user->phone,
            $user->sub == 1?"已订阅":"",
            $gender,
            $type,
            $user->created_at,
        ];
    }
}
