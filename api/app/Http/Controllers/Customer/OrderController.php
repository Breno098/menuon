<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function my(Request $request): JsonResponse
    {
        /** @var Customer */
        $customer = $request->user('customer');

        return response()->json([
            'orders' => $customer->orders->map(function(Order $order) {
                return [
                    'id' => $order->id,
                    'status' => $order->status,
                    'payment_method' => $order->payment_method,
                    'total_price' => $order->total_price,
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
                    'delivery_address' => [
                        'cep' => $order->deliveryAddress->cep,
                        'street' => $order->deliveryAddress->street,
                        'number' => $order->deliveryAddress->number,
                        'district' => $order->deliveryAddress->district,
                        'complement' => $order->deliveryAddress->complement,
                        'city' => $order->deliveryAddress->city,
                        'state' => $order->deliveryAddress->state,
                        'country' => $order->deliveryAddress->country,
                    ]
                ];
            })
        ]);
    }

     /**
     * @param Product $product
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        /** @var Customer */
        $customer = $request->user('customer');

        $address = $customer->addresses()->updateOrCreate([
            'cep' => $request->input('address.cep'),
            'street' => $request->input('address.street'),
            'number' => $request->input('address.number'),
            'district' => $request->input('address.district'),
            'complement' => $request->input('address.complement'),
            'city' => $request->input('address.city'),
            'state' => $request->input('address.state'),
            'country' => $request->input('address.country', 'Brasil'),
        ], [
            'cep' => $request->input('address.cep'),
            'street' => $request->input('address.street'),
            'number' => $request->input('address.number'),
            'district' => $request->input('address.district'),
            'complement' => $request->input('address.complement'),
            'city' => $request->input('address.city'),
            'state' => $request->input('address.state'),
            'country' => $request->input('address.country', 'Brasil'),
        ]);

        /** @var Order */
        $order = $customer->orders()->create([
            'status' => 'pending_approval',
            'payment_method' => $request->input('paymentMethod'),
        ]);

        $order->deliveryAddress()->associate($address);

        $order->save();

        foreach ($request->input('items', []) as $item) {
            /** @var Product */
            $product = Product::query()->find($item['id']);

            $mainItem = $order->items()->create([
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'product_id' => $product->id,
            ]);

            foreach ($item['additional'] as $additional) {
                $additionalItem = $product->additional()->where('products.id', $additional['id'])->first();

                if ($additionalItem) {
                    $mainItem->additional()->attach($additionalItem, [
                        'additional_product_id' => $additionalItem->id,
                        'price' => $additionalItem->price,
                        'quantity' => $additional['quantity'],
                    ]);
                }
            }
        }

        return response()->json([
            'order' => $order->fresh()
        ]);
    }
}
