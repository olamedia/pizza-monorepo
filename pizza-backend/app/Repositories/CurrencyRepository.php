<?php
declare(strict_types=1);

namespace App\Repositories;

final class CurrencyRepository
{
    public function getRates()
    {
        return [
            'USD' =>  1,
            'EUR' => 1.1767
        ];
    }
}
