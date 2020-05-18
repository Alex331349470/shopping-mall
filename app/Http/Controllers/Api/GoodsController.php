<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\GoodResource;
use App\Http\Resources\GoodSkuResource;
use App\Http\Resources\ReplyImageResource;
use App\Http\Resources\ReplyResource;
use App\Models\Good;
use App\Models\GoodSku;
use App\Models\Reply;
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
        $replies = Reply::query()->whereGoodId($good->id)->with('user')->get();
        return new ReplyResource($replies);
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
                    ->orWhere('description', 'like', $like);
            });

            $goods = $builder->with('images','category')->paginate(9);

            return new GoodResource($goods);
        }
    }

    public function hotIndex(Request $request)
    {
//        $goods = Good::query()->where('on_sale', true)->where('on_hot',true)->with('images','category')->paginate(6);
        $goods = Good::query()->where('description', 'like', '	法兰琳卡')->with('images', 'category')->paginate(6);
        if (!$goods) {
            abort(403, '没有商品');
        }

        return new GoodResource($goods);
    }

    public function favor(Good $good, Request $request)
    {
        $user = $request->user();

        if ($user->favoriteGoods()->find($good->id)) {
            abort(403,'该商品已收藏');
        }

        $user->favoriteGoods()->attach($good);

        return response(null,201);
    }

    public function skus(Good $good)
    {
        $skus = GoodSku::query()->where('good_id',$good->id)->get();
        GoodSkuResource::wrap('data');
        return new GoodSkuResource($skus);
    }

    public function disfavor(Good $good,Request $request)
    {
        $user = $request->user();
        $user->favoriteGoods()->detach($good);

        return response(null,204);
    }

    public function favoriteStatus(Good $good, Request $request)
    {
        $user = $request->user();

        if ($user->favoriteGoods()->find($good->id)) {
            return response()->json([
                'message' => '商品已收藏',
                'code' => 100001
            ]);
        }

        return response()->json([
            'message' => '商品未收藏',
            'code' => 100002
        ]);
    }

    public function favorites(Request $request)
    {
        $goods = $request->user()->favoriteGoods()->with('images','category')->paginate(16);

        return new GoodResource($goods);
    }

}
