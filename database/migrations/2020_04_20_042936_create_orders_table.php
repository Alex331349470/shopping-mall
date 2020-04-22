<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('自增id');
            $table->string('no', 100)->unique()->comment('订单号');
            $table->unsignedBigInteger('user_id')->comment('外键用户id');
            $table->text('address')->comment('用户地址');
            $table->decimal('total_amount', 10, 2)->comment('订单总价');
            $table->text('remark')->nullable()->comment('订单备注');
            $table->dateTime('paid_at')->nullable()->comment('支付时间');
            $table->string('payment_method')->nullable()->comment('支付方式');
            $table->string('payment_no')->nullable()->comment('支付流水号');
            $table->string('user_type')->default(0)->comment('用户类型 0-普通客户 1-二级代销 2-一级代销');
            $table->decimal('bonus')->default(0)->comment('订单返利');
            $table->string('refund_status')->default('refund_pending')->comment('退款退货状态');
            $table->string('refund_no', 100)->unique()->nullable()->comment('退款退货单号');
            $table->boolean('closed')->default(false)->comment('订单是否关闭');
            $table->boolean('reply_status')->default(0)->comment('订单是否已评价');
            $table->boolean('cancel')->default(0)->comment('订单是否取消');
            $table->string('ship_status')->default('ship_pending')->comment('订单物流状态');
            $table->text('ship_data')->nullable()->comment('物流信息');
            $table->text('extra')->nullable()->comment('其他订单额外数据');
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
        Schema::dropIfExists('orders');
    }
}
