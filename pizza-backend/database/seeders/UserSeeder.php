<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Database\Factories\CartItemFactory;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @var \App\Models\User
         */
        $guest = User::factory()->guest()->create();

        /**
         * @var \App\Models\User
         */
        $admin = User::factory()->admin()->has(
            Order::factory()->count(10)->has(
                OrderItem::factory()->count(5)
            )
        )->has(
            CartItem::factory()->count(5)
        )->create();
    }
}
