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
        return CategoryResource::collection(Category::all());
    }

    public function goodIndex(Category $category)
    {
        $goods = $category->goods()->with('images','category')->paginate(9);
        GoodResource::wrap('data');
        return new GoodResource($goods);
    }
}
