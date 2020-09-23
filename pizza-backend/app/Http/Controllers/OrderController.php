<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Repositories\CurrencyRepository;
use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

final class OrderController extends Controller
{
    private $currencyRepository;

    private $orderItemRepository;

    private $orderRepository;

    public function __construct(
        CurrencyRepository $currencyRepository,
        OrderRepository $orderRepository,
        OrderItemRepository $orderItemRepository
    ) {
        $this->currencyRepository = $currencyRepository;
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
    }

    public function createForCurrentUser(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        if (!$user){
            $user = User::findGuest();
        }
        if (!$user) {
            abort(500, 'No guest configured');
        }

        $params = $request->only('items', 'details', 'currency');
        $orderCurrency = $params['currency'];
        $orderTotal = 0;
        $rates = $this->currencyRepository->getRates();
        if (!isset($rates[$orderCurrency])) {
            abort(400, "Rate for {$orderCurrency} not found");
        }

        // delivery
        $deliveryPrice = 10;
        $deliveryCurrency = 'USD';
        $deliveryPriceInOrderCurrency = \round(($orderCurrency === $deliveryCurrency) ?
            $deliveryPrice :
            $deliveryPrice * $rates[$deliveryCurrency] / $rates[$orderCurrency], 2);
        $orderTotal += $deliveryPriceInOrderCurrency;

        $orderProperties = [
            'full_name' => $params['details']['fullName'],
            'address' => $params['details']['address'],
            'currency' => $orderCurrency,
            'delivery_price' => $deliveryPriceInOrderCurrency
        ];
        $order = $user ? $user->orders()->make($orderProperties) : Order::make($orderProperties);
        $order->saveOrFail();

        $orderItems = [];
        $orderProducts = [];
        foreach ($params['items'] as $item) {
            $productId = $item['product_id'];
            $quantity = $item['quantity'];
            $product = Product::find($productId);
            if ($product) {
                $orderProducts[] = $product;
                if (isset($rates[$product->price_currency])) {
                    $price = ($orderCurrency === $product->price_currency) ?
                        $product->price :
                        $product->price * $rates[$product->price_currency] / $rates[$orderCurrency];
                    $price = \round($price, 2);
                    $orderTotal += $price * $quantity;

                    $orderItem = $order->orderItems()->make([
                        'product_id' => $productId,
                        'name' => $product->name,
                        'price' => $price,
                        'price_currency' => $orderCurrency,
                        'quantity' => $quantity
                    ]);
                    $orderItem->saveOrFail();
                    $orderItems[] = $orderItem;
                }
            }
        }



        return \response()->json([
            'order' => \array_merge(['total' => $orderTotal], $order->toArray()),
            'items' => $orderItems,
            'products' => $orderProducts
        ]);
    }

    public function index($orderId, Request $request)
    {
        $user = $request->user();

        abort_if(!$user, 403);

        $order = $this->orderRepository->getByIdForUserId($orderId, $user->id);

        $orderItems = $order->orderItems;

        $orderTotal = \array_reduce(\iterator_to_array($orderItems), function($carry, $orderItem){
            return $carry + $orderItem->price * $orderItem->quantity;
        }, 0);

        $orderTotal += $order->delivery_price;

        return \response()->json([
            'order' => \array_merge(['total' => $orderTotal], $order->toArray()),
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
