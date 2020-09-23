<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\CartItem;

final class CartItemRepository
{
    public function getAllForUserId($userId, $perPage = 10)
    {
        return CartItem::query()->where('user_id', $userId)->get();
    }
    public function replaceAllForUserId($userId, $newItems)
    {
        $currentItems = CartItem::query()->where('user_id', $userId)->get();

        $currentItemsByProductId = [];
        foreach ($currentItems as $currentItem) {
            $currentItemsByProductId[$currentItem->product_id] = $currentItem;
        }
        $currentProductIds = \array_keys($currentItemsByProductId);

        $newItemsByProductId = [];
        foreach ($newItems as $newItem) {
            $newItemsByProductId[$newItem['product']['id']] = $newItem;
        }
        $newProductIds = \array_keys($newItemsByProductId);

        $productIdsToDelete = \array_diff($currentProductIds, $newProductIds);
        CartItem::query()
            ->where('user_id', $userId)
            ->whereIn('product_id', $productIdsToDelete)->delete();

        $productIdsToInsert = \array_diff($newProductIds, $currentProductIds);
        foreach ($productIdsToInsert as $productId){
            $newItem = $newItemsByProductId[$productId];
            /** @var \App\Models\CartItem $item */
            $item = CartItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $newItem['quantity']
            ]);
            $item->save();
        }

        $productIdsToUpdate = \array_intersect($newProductIds, $currentProductIds);
        foreach ($productIdsToUpdate as $productId){
            $newItem = $newItemsByProductId[$productId];
            CartItem::query()
                ->where('user_id', $userId)
                ->where('product_id', $productId)
                ->update(['quantity' => $newItem['quantity']]);
        }

        return [
            'new_products' => $newProductIds,
            'deleted' => $productIdsToDelete,
            'inserted' => $productIdsToInsert,
            'updated' => $productIdsToUpdate
        ];
    }


}
