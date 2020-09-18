<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(30),
            'description' => $this->faker->text(100),
            'price' => $this->faker->randomFloat(2, 2.5, 9),
            'price_currency' => $this->faker->randomElement(['USD', 'EUR'])
        ];
    }

    public function pizza(){
        return $this->state(function ($faker) {
            return [
                'name' => $this->faker->city . ' pizza',
                'price' => $this->faker->randomFloat(2, 2.5, 9),
            ];
        });
    }
}
