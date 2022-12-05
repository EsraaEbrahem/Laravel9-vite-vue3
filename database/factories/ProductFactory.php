<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => 1,
            'name' => $this->faker->name(),
            'description' => $this->faker->name(),
            'available_stock' => rand(1, 10),
            'rate' => rand(1, 10),
            'cost' => rand(500, 1000),
            'image' => "",
            'created_by' => 1,
        ];
    }
}
