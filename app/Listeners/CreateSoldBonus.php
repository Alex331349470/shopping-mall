<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Models\Bonus;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateSoldBonus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param OrderPaid $event
     * @return void
     */
    public function handle(OrderPaid $event)
    {
        $order = $event->getOrder();

        $user = User::find($order->user_id);

        if ($parent_id = $user->userInfo->parent_id) {

            $total_amount = $order->total_amount;

            $bonus = ($total_amount*2)/100;

            $parent_user = User::find($parent_id);

            Bonus::create([
                'user_id' => $parent_id,
                'order_id' => $order->id,
                'user_type' => $parent_user->userInfo->type,
                'bonus' => $bonus,
            ]);
        }

    }
}
