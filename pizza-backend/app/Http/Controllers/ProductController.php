<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\Facades\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;

final class ProductController extends Controller
{
    public function paginate(Response $response, Request $request)
    {
        $perPage = 12;

        $request->validate([
            'page' => ['integer', 'min:1'],
        ]);

        $page = $request->input('page');

        $items = ProductRepository::paginateAll($perPage);

        return \response()->json($items);
    }
}
