<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

final class OrderController extends Controller
{
    private $orderItemRepository;

    private $orderRepository;

    public function __construct(OrderRepository $orderRepository, OrderItemRepository $orderItemRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
    }

    public function index($orderId, Request $request)
    {
        $user = $request->user();

        abort_if(!$user, 403);

        $order = $this->orderRepository->getByIdForUserId($orderId, $user->id);

        $orderItems = $this->orderItemRepository->getAllForOrderId($orderId, $user->id);

        return \response()->json([
            'order' => $order,
            'items' => $orderItems
        ]);
    }

    public function listForCurrentUser(Request $request)
    {
        $user = $request->user();

        abort_if(!$user, 403);

        $orders = $this->orderRepository->paginateForUserId($user->id);

        return \response()->json($orders);
    }
}
