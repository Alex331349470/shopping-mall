<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\GoodResource;
use App\Http\Resources\ReplyImageResource;
use App\Http\Resources\ReplyResource;
use App\Models\Good;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    public function show(Good $good)
    {
        return new GoodResource($good->with('images','category')->where('id',$good->id)->first());
    }

    public function replyIndex(Good $good)
    {
        ReplyResource::wrap('data');
        return new ReplyResource($good->replies);
    }

    public function replyImageIndex(Good $good)
    {
        ReplyImageResource::wrap('data');
        return new ReplyImageResource($good->replyImages);
    }

    public function index(Request $request)
    {
        $builder = Good::query()->where('on_sale', true);
        // 判断是否有提交 search 参数，如果有就赋值给 $search 变量
        // search 参数用来模糊搜索商品
        if ($search = $request->input('search', '')) {
            $like = '%' . $search . '%';
            // 模糊搜索商品标题、商品详情
            $builder->where(function ($query) use ($like) {
                $query->where('title', 'like', $like)
                    ->orWhere('description', 'like', $like)
                    ->orWhere('art', 'like', $like);
            });

            $goods = $builder->with('images','category')->paginate(9);

            return new GoodResource($goods);
        }
    }
}
