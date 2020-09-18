<?php
declare(strict_types=1);


namespace App\Repositories;


use App\Models\Product;

class ProductRepository
{

    public function paginateAll($page = null, $perPage = null){
        return Product::query()->paginate($perPage, ['*'], 'page', $page);
    }
}