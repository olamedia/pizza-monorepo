<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;

final class ProductController extends Controller
{
    /**
     * @var \App\Http\Controllers\ShopItemRepository
     */
    private $shopItemRepository;

    /**
     * ShopController constructor.
     */
    public function __construct(ProductRepository $shopItemRepository)
    {
        $this->shopItemRepository = $shopItemRepository;
    }

    public function paginate(Response $response, Request $request)
    {
        $perPage = 12;

        $request->validate([
            'page' => ['integer', 'min:1'],
        ]);

        $page = $request->input('page');

        $items = $this->shopItemRepository->paginateAll($perPage);

        return \response()->json($items);
//        View::make('shop.index', [
//            'items' => $items
//        ]);
    }
}
