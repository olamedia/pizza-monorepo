<?php
declare(strict_types=1);


namespace App\Repositories;


use App\Models\Order;
use App\Models\OrderItem;

class OrderItemRepository
{
    public function getAllForOrderId($orderId, $userId){
        return OrderItem::query()->where('order_id', $orderId)->get();
    }
}
