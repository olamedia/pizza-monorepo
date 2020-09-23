<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\CartItemRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

final class CartItemController extends Controller
{
    private $cartItemRepository;

    private $productRepository;

    public function __construct(CartItemRepository $cartItemRepository, ProductRepository $productRepository)
    {
        $this->cartItemRepository = $cartItemRepository;
        $this->productRepository = $productRepository;
    }

    public function replaceForCurrentUser(Request $request)
    {
        $user = $request->user();
        abort_if(!$user, 403);

        \var_dump($request->all());

        $mergeInfo = $this->cartItemRepository->replaceAllForUserId($user->id, $request->input('items'));
        \var_dump($mergeInfo);

        $cartItems = $this->cartItemRepository->getAllForUserId($user->id);

        $productIds = \array_values(\array_map(
            function ($cartItem) {
                return $cartItem['product_id'];
            }, $cartItems->toArray()
        ));

        $products = $this->productRepository->getAllIn($productIds);

        return \response()->json([
            'items' => $cartItems,
            'products' => $products
        ]);
    }
    public function listForCurrentUser(Request $request)
    {
        $user = $request->user();
        abort_if(!$user, 403);

        $cartItems = $this->cartItemRepository->getAllForUserId($user->id);

        $productIds = \array_values(\array_map(
            function ($cartItem) {
                return $cartItem['product_id'];
            }, $cartItems->toArray()
        ));

        $products = $this->productRepository->getAllIn($productIds);

        return \response()->json([
            'items' => $cartItems,
            'products' => $products
        ]);
    }
}
