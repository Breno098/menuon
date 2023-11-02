<?php

namespace App\Http\Resources\Customer\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class My extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Order */
        $order = $this->resource;

        return [
            'id' => $order->id,
            'status' => $order->status,
            'payment_method' => $order->payment_method,
            'total_price' => $order->total_price,
            'delivery_address' => new DeliveryAddress($order->deliveryAddress),
            'items' => $order->items->map(fn (OrderItem $item) => [
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total_price' => $item->total_price,
                'customer_notes' => $item->customer_notes,
                'product' => [
                    'id' => $item->id,
                    'name' => $item->product->name,
                ],
                'additional' => $item->additional->map(function (Product $additional) {
                    return [
                        'id' => $additional->id,
                        'name' => $additional->name,
                        'price' => $additional->additional_price,
                        'quantity' => $additional->additional_quantity,
                    ];
                })
            ]),
        ];
    }
}
