<?php

namespace App\Http\Requests\Api;


use App\Models\Good;
use Illuminate\Contracts\Validation\Rule;

class OrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            // 判断用户提交的地址 ID 是否存在于数据库并且属于当前用户
            // 后面这个条件非常重要，否则恶意用户可以用不同的地址 ID 不断提交订单来遍历出平台所有用户的收货地址
            'address_id'     => [
                'required',
//                Rule::exists('user_addresses', 'id')->where('user_id', $this->user()->id),
            ],
            'good_ids'  => ['required', 'string'],
//            'items.*.good_id' => [ // 检查 items 数组下每一个子数组的 good_id 参数
//                'required',
//                function ($attribute, $value, $fail) {
//                    if (!$good = Good::find($value)) {
//                        return $fail('该商品不存在');
//                    }
//                    if (!$good->on_sale) {
//                        return $fail('该商品未上架');
//                    }
//                    if ($good->stock === 0) {
//                        return $fail('该商品已售完');
//                    }
//                    // 获取当前索引
//                    preg_match('/items\.(\d+)\.good_id/', $attribute, $m);
//                    $index = $m[1];
//                    // 根据索引找到用户所提交的购买数量
//                    $amount = $this->input('items')[$index]['amount'];
//                    if ($amount > 0 && $amount > $good->stock) {
//                        return $fail('该商品库存不足');
//                    }
//                },
//            ],
        ];
    }
}
