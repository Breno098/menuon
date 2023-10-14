<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
     /**
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json([
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
            'additional' => $product->additional->map(function (Product $additional) {
                return [
                    'id' => $additional->id,
                    'name' => $additional->name,
                    'price' => $additional->additional_price,
                ];
            })
        ]);
    }
}
