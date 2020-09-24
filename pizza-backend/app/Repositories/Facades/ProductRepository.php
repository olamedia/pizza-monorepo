<?php
declare(strict_types=1);

namespace App\Repositories\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method getAllIn($ids)
 * @method paginateAll($perPage = null)
 */
final class ProductRepository extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Repositories\ProductRepository::class;
    }
}
