<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('自增id');
            $table->string('title')->comment('商品名称');
            $table->string('description')->nullable()->comment('商品描述');
            $table->boolean('on_hot')->default(true)->comment('推荐标识');
            $table->boolean('on_sale')->default(true)->comment('上架标识');
            $table->text('content')->comment('商品详情');
            $table->decimal('express_price', 10, 2)->default(0)->comment('市场价');
            $table->decimal('price', 10, 2)->default(0)->comment('售价');
            $table->float('rating')->default(5)->comment('星级平均评分');
            $table->integer('category_id')->index('category_id')->comment('分类id');
            $table->string('good_no')->nullable()->comment('货号');
            $table->unsignedInteger('stock')->default(0)->comment('库存');
            $table->unsignedInteger('sold_count')->default(0)->comment('销量');
            $table->unsignedInteger('review_count')->default(0)->comment('浏览量');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods');
    }
}
