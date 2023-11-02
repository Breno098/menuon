<?php

namespace App\Services\Customer;

use App\Models\Address;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class OrderService 
{
    /**
     * @param AddressService $addressService
     */
    public function __construct(
        private readonly AddressService $addressService
    ){}

    /**
     * @param Customer $customer
     * @return Collection<Order>
     */
    public function myOrders(Customer $customer): Collection
    {
        return $customer->orders()->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param Customer $customer
     * @param array $params
     * @return Order
     */
    public function store(Customer $customer, array $params = []): Order
    {
        /** @var Address */
        $address = $this->addressService->updateOrCreate($customer, Arr::get($params, 'address'));

        /** @var Order */
        $order = $customer->orders()->create([
            'status' => 'pending_approval',
            'payment_method' => Arr::get($params, 'paymentMethod'),
        ]);

        $order->deliveryAddress()->associate($address);

        $order->save();

        $this->attachItems($order, Arr::get($params, 'items', []));

        return $order->fresh();
    }

      /**
     * @param Order $order
     * @param array $items
     * @return void 
     */
    public function attachItems(Order $order, array $items = []): void
    {
        foreach ($items as $item) {
            /** @var Product */
            if (! Arr::get($item, 'id')) {
                continue;
            }

            $product = Product::query()->find(Arr::get($item, 'id'));

            $mainItem = $order->items()->create([
                'quantity' => Arr::get($item, 'quantity', 1),
                'price' => $product->price,
                'product_id' => $product->id,
            ]);

            foreach (Arr::get($item, 'additional') as $additional) {
                if (! Arr::get($additional, 'id')) {
                    continue;
                }

                $additionalItem = $product->additional()->where('products.id', $additional['id'])->first();

                if ($additionalItem) {
                    $mainItem->additional()->attach($additionalItem, [
                        'additional_product_id' => $additionalItem->id,
                        'price' => $additionalItem->price,
                        'quantity' => Arr::get($additional, 'quantity', 1),
                    ]);
                }
            }
        }
    }
}