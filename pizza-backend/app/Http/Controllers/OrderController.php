<?php

namespace App\Http\Controllers;

use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $orderRepository;
    private $orderItemRepository;

    public function __construct(OrderRepository $orderRepository, OrderItemRepository $orderItemRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
    }

    public function index($orderId, Request $request){
        $user = $request->user();

        $order = $this->orderRepository->getByIdForUserId($orderId, $user->id);

        $orderItems = $this->orderItemRepository->getAllForOrderId($orderId, $user->id);

        return \response()->json([
            'order' => $order,
            'items' => $orderItems
        ]);
    }

    public function listForCurrentUser(Request $request){
        $user = $request->user();

        $orders = $this->orderRepository->paginateForUserId($user->id);

        return \response()->json($orders);
    }
}
