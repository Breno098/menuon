<?php

namespace App\Services\Admin;

use App\Models\Order;

class OrderService 
{
    /**
     * @param Order $order
     * @return void
     */
    public function nextStatus(Order $order): void
    {
        $statusSorted = [
            'pending_approval', 
            'preparing', 
            'delivery',
            'concluded', 
        ];

        $key = array_search($order->status, $statusSorted);
        $nextKey = ++$key;

        if ($nextKey !== count($statusSorted)) {
            $order->update(['status' => $statusSorted[$nextKey]]);
        }
    }
}