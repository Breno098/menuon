<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

        dd('here');

        $address = $customer->addresses()->updateOrCreate([
            'cep' => $request->get('address.cep'),
            'street' => $request->get('address.street'),
            'number' => $request->get('address.number'),
            'district' => $request->get('address.district'),
            'complement' => $request->get('address.complement'),
            'city' => $request->get('address.city'),
            'state' => $request->get('address.state'),
            'country' => $request->get('address.country', 'Brasil'),
        ], [
            'cep' => $request->get('address.cep'),
            'street' => $request->get('address.street'),
            'number' => $request->get('address.number'),
            'district' => $request->get('address.district'),
            'complement' => $request->get('address.complement'),
            'city' => $request->get('address.city'),
            'state' => $request->get('address.state'),
            'country' => $request->get('address.country', 'Brasil'),
        ]);

        /** @var Order */
        $order = Order::create([
            'status' => 'pending_approval',
            'payment_method' => $request->get('paymentMethod'),
        ]);

        $order->customer()->associate($customer);
        
        $order->deliveryAddress()->associate($address);

        $order->save();

        foreach ($request->get('items', []) as $item) {
            /** @var Product */
            $product = Product::query()->find($item['id']);

            $mainItem = $order->items()->create([
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'product_reference_id' => $product->id,
            ]);

            foreach ($item['additional'] as $additional) {
                $additionalItem = $product->additional()->where('id', $additional['id'])->first();

                if ($additionalItem) {
                    $mainItem->additional()->attach($additionalItem, [
                        'additional_product_id' => $additionalItem->id,
                        'price' => $additionalItem->price,
                    ]);
                }
            }
        }

        return response()->json([
            'order' => $order->fresh()
        ]);
    }
}
