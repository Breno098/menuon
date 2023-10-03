<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::factory()
            ->has(Address::factory()->count(2))
            ->hasAttached(Product::all()->random(2), [], 'shoppingCart')
            ->create([
                'name' => 'Customer',
                'email' => 'customer@customer.com',
            ]);

        Customer::factory()
            ->has(Address::factory()->count(2))
            ->hasAttached(Product::all()->random(2), [], 'shoppingCart')
            ->count(20)
            ->create();
    }
}
