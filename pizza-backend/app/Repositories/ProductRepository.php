<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;

final class ProductRepository
{
    public function getAllIn($ids)
    {
        return Product::query()->whereIn('id', $ids)->get();
    }

    public function paginateAll($perPage = null)
    {
        return Product::query()->paginate($perPage);
    }
}
