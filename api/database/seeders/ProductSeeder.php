<?php

namespace Database\Seeders;

use App\Models\FoodSession;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bacon = Product::factory()->create([
            'name' => 'Bacon',
            'price' => 4.99
        ]);

        $onion = Product::factory()->create([
            'name' => 'Cebola',
            'price' => 2
        ]);

        $cheese = Product::factory()->create([
            'name' => 'Queijo',
            'price' => 5.49
        ]);

        $chocolate = Product::factory()->create([
            'name' => 'Chocolate',
            'price' => 7.99
        ]);

        $pizzaSession = FoodSession::create([
            'title' => 'Pizza',
            'image' => \App\Helpers\Seeder\Random::image(),
        ]);

        $burguerSession = FoodSession::create([
            'title' => 'Hambúrguer',
            'image' => \App\Helpers\Seeder\Random::image(),
        ]);

        $dessertSession = FoodSession::create([
            'title' => 'Sobremesa',
            'image' => \App\Helpers\Seeder\Random::image(),
        ]);

        Product::factory()
            ->state(['name' => 'Pizza Dumbledore'])
            ->has(ProductImage::factory()->count(2), 'images')
            ->hasAttached($bacon, [
                'additional_product_id' => $bacon->id,
                'price' => $bacon->price,
            ], 'additional')
            ->hasAttached($onion, [
                'additional_product_id' => $onion->id,
                'price' => $onion->price,
            ], 'additional')
            ->hasAttached($cheese, [
                'additional_product_id' => $cheese->id,
                'price' => $cheese->price,
            ], 'additional')
            ->hasAttached($pizzaSession, [], 'sessions')
            ->create();

        Product::factory()
            ->has(ProductImage::factory()->count(2), 'images')  
            ->hasAttached($bacon, [
                'additional_product_id' => $bacon->id,
                'price' => $bacon->price,
            ], 'additional')
            ->hasAttached($cheese, [
                'additional_product_id' => $cheese->id,
                'price' => $cheese->price,
            ], 'additional')
            ->hasAttached($burguerSession, [], 'sessions')
            ->state(['name' => 'Burguer hermione'])
            ->create();

        Product::factory()
            ->has(ProductImage::factory()->count(2), 'images')  
            ->hasAttached($bacon, [
                'additional_product_id' => $bacon->id,
                'price' => $bacon->price,
            ], 'additional')
            ->hasAttached($cheese, [
                'additional_product_id' => $cheese->id,
                'price' => $cheese->price,
            ], 'additional')
            ->hasAttached($burguerSession, [], 'sessions')
            ->state(['name' => 'Burguer Harry Potter'])
            ->create();

        Product::factory()
            ->has(ProductImage::factory()->count(2), 'images') 
            ->hasAttached($bacon, [
                'additional_product_id' => $bacon->id,
                'price' => $bacon->price,
            ], 'additional')
            ->hasAttached($onion, [
                'additional_product_id' => $onion->id,
                'price' => $onion->price,
            ], 'additional')
            ->hasAttached($cheese, [
                'additional_product_id' => $cheese->id,
                'price' => $cheese->price,
            ], 'additional')
            ->hasAttached($pizzaSession, [], 'sessions')
            ->state(['name' => 'Pizza Voldemort'])
            ->create();

        Product::factory()
            ->has(ProductImage::factory()->count(2), 'images') 
            ->hasAttached($chocolate, [
                'additional_product_id' => $chocolate->id,
                'price' => $chocolate->price,
            ], 'additional')
            ->hasAttached($dessertSession, [], 'sessions')
            ->state(['name' => 'Sorvete Sirius'])
            ->create();
    }
}
