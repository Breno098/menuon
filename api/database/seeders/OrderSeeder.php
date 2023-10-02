<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory()
            ->count(20)
            ->state(function() {
                $customer = Customer::all()->random();

                return [
                    'customer_id' => $customer->id,
                    'delivery_address_id' => $customer->addresses->random()->id,
                ];
            })
            ->create()
            ->each(function (Order $order) {
                Product::all()->random(2)->each(fn(Product $product) => $order->items()->create([
                    'quantity' => fake()->numberBetween(1, 3),
                    'info' => fake()->realText(20),
                    'customer_notes' => fake()->realText(20),
                    'price' => $product->price,
                    'product_reference_id' => $product->id,
                ]));
            });
    }
}
