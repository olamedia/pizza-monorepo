<?php
declare(strict_types=1);


namespace App\Repositories;


use App\Models\Order;

class OrderRepository
{
    public function getByIdForUserId($orderId, $userId){
        return Order::query()->where([
            'id' => $orderId,
            'user_id' => $userId
        ])->firstOrFail();
    }

    public function paginateForUserId($userId, $perPage = 10){
        return Order::query()->where('user_id', $userId)->paginate($perPage);
    }
}
