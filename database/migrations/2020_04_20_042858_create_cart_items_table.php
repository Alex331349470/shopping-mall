<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('自增id');
            $table->unsignedBigInteger('user_id')->comment('外键用户id');
            $table->unsignedBigInteger('good_id')->comment('外键商品id');
            $table->boolean('cartExist')->nullable()->comment('是否在购物车内，不是则是立即购买');
            $table->unsignedBigInteger('amount')->comment('购买数量');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
}
