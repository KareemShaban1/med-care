<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Order;

class OrderObserver extends GenericObserver
{
    //
    public function creating(Order $order){
        $order->uuid = Str::uuid()->toString();
    }
}
