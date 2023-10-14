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
            'image' => 'https://uploads.metropoles.com/wp-content/uploads/2023/08/09145143/Pizza-31.jpg',
        ]);

        $burguerSession = FoodSession::create([
            'title' => 'Hambúrguer',
            'image' => 'https://images.unsplash.com/photo-1586816001966-79b736744398?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8aGFtYnVyZ3VlcnxlbnwwfHwwfHx8MA%3D%3D&w=1000&q=80',
        ]);

        $dessertSession = FoodSession::create([
            'title' => 'Sobremesa',
            'image' => 'https://images7.alphacoders.com/396/396289.jpg',
        ]);

        $drinksSession = FoodSession::create([
            'title' => 'Bebidas',
            'image' => 'https://img.freepik.com/fotos-gratis/bebidas-coloridas-em-um-bar-com-luzes-coloridas_1340-34312.jpg',
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
            ->state(['name' => 'Burguer Hermione'])
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

        Product::factory()
            ->has(ProductImage::factory()->count(1), 'images') 
            ->hasAttached($drinksSession, [], 'sessions')
            ->state(['name' => 'Suco Hogwarts'])
            ->create();

        Product::factory()
            ->has(ProductImage::factory()->count(1), 'images') 
            ->hasAttached($drinksSession, [], 'sessions')
            ->state(['name' => 'Cerveja Snape'])
            ->create();
    }
}
