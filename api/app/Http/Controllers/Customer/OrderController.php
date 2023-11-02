<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Services\Customer\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Customer\Order\My as MyOrders;

class OrderController extends Controller
{
    /**
     * @param OrderService $orderService
     */
    public function __construct(
        protected readonly OrderService $orderService
    ) {}

    public function my(Request $request): JsonResponse
    {
        /** @var Customer */
        $customer = $request->user('customer');

        $orders = $this->orderService->myOrders($customer);

        return response()->json([
            'orders' => MyOrders::collection($orders)
        ]);
    }

     /**
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        /** @var Customer */
        $customer = $request->user('customer');

        $order = $this->orderService->store($customer, $request->all());

        return response()->json([
            'order' => $order
        ]);
    }
}
