<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodSkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('good_skus', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('自增id');
            $table->string('title')->comment('sku商品名称');
            $table->string('description')->comment('sku商品描述');
            $table->decimal('price', 10, 2)->comment('sku商品价格');
            $table->unsignedInteger('stock')->comment('sku商品数量');
            $table->unsignedBigInteger('good_id')->comment('外键商品id');
            $table->foreign('good_id')->references('id')->on('goods')->onDelete('cascade')->comment('外键约束');
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
        Schema::dropIfExists('good_skus');
    }
}
