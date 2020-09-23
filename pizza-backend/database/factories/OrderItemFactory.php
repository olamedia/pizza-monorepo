<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

final class OrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product = Product::all()->random();
        return [
            'order_id' => Order::factory(),
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'price_currency' => $product->price_currency,
            'quantity' => $this->faker->numberBetween(1, 3)
        ];
    }
}
