<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\FoodSession;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\JsonResponse;

class FoodSessionController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'food_sessions' => FoodSession::get()->map(function(FoodSession $session) {
                return [
                    'id' => $session->id,
                    'title' => $session->title,
                    'description' => $session->description,
                    'image' => $session->image,
                ];
            })
        ]);
    }

    /**
     * @param FoodSession $foodSession
     * @return JsonResponse
     */
    public function show(FoodSession $foodSession): JsonResponse
    {
        return response()->json([
            'food_session' => [
                'id' => $foodSession->id,
                'title' => $foodSession->title,
                'description' => $foodSession->description,
                'image' => $foodSession->image,
                'products' => $foodSession->products->map(function(Product $product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product->price,
                        'images' => $product->images->map(function(ProductImage $image) {
                            return [
                                'title' => $image->title,
                                'path' => $image->path,
                            ];
                        }),
                    ];
                })
            ]
        ]);
    }
}
