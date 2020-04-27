<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\GoodResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        CategoryResource::wrap('data');
        $categories = Category::query()->whereNull('parent_id')->get();

        if (!$categories) {
            abort(403, '无分类目录');
        }
        return CategoryResource::collection($categories);
    }

    public function directory(Category $category)
    {
        $categories = Category::query()->where('parent_id', $category->id)->get();
        if (!$categories) {
            abort(403,'无二级分类');
        }
        CategoryResource::wrap('data');
        return CategoryResource::collection($categories);
    }

    public function goodIndex(Category $category)
    {
        $goods = $category->goods()->with('images','category')->paginate(8);
        GoodResource::wrap('data');
        return new GoodResource($goods);
    }
}
