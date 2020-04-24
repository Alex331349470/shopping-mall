<?php

namespace App\Observers;

use App\Http\Requests\Request;
use App\Models\UserAddress;

class UserAddressObserver
{
    public function creating(UserAddress $user_address)
    {
        if (!UserAddress::whereUserId($user_address->user_id)->whereDefaultAddress(1)->first()){
            $user_address->default_address = 1;
        }
    }
}
