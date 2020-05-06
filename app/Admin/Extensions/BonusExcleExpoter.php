<?php
namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Concerns\WithMapping;

class BonusExcleExpoter extends ExcelExporter implements WithMapping {
    protected $fileName = '绩效管理.xlsx';

    protected $headings = [
        'id'      => 'ID',
        'name'   => '姓名',
        'phone' => '手机号',
        'user_type' => '用户类型',
        'bonus' => '提成',
        'year_month1' => '统计月份',
    ];


    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($bonus): array
    {
        return [
            $bonus->id,
            $bonus->name,
            $bonus->phone,
            $bonus->new_user_type,
            $bonus->bonus,
            $bonus->year_month1,
        ];
    }
}
