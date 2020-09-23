<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

final class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'full_name' => $this->faker->firstName.' '.$this->faker->lastName,
            'address' => $this->faker->address,
            'currency' => $this->faker->randomElement(['USD', 'EUR']),
            'delivery_price' => $this->faker->randomFloat(2, 5, 10),
        ];
    }
}
