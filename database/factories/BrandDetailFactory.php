<?php

namespace Database\Factories;

use App\Models\BrandDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BrandDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            
'brand_id' => $this->faker->unique()->numberBetween(1, 100),
'description' => $this->faker->sentence,
'status' => $this->faker->word(),
'brand_image' => $this->faker->sentence,
'bg_color' => $this->faker->sentence,
        ];
    }
}
