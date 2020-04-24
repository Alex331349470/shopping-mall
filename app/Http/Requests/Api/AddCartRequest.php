<?php

namespace App\Http\Requests\Api;


use App\Models\Good;

class AddCartRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'good_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!$good = Good::find($value)) {
                        return $fail('该商品不存在');
                    }
                    if (!$good->on_sale) {
                        return $fail('该商品未上架');
                    }
                    if ($good->stock === 0) {
                        return $fail('该商品已售完');
                    }
                    if ($this->input('amount') > 0 && $good->stock < $this->input('amount')) {
                        return $fail('该商品库存不足');
                    }
                },
            ],
            'amount' => ['required', 'integer', 'min:1'],
            'cartExist' => 'required',
        ];
    }
    public function attributes()
    {
        return [
            'amount' => '商品数量'
        ];
    }

    public function messages()
    {
        return [
            'good_id.required' => '请选择商品'
        ];
    }
}
