<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Brand::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            
'name' => $this->faker->unique()->text(5),
'remark' => $this->faker->unique()->text(5),
'status' => $this->faker->unique()->randomElement(range('A', 'Z')),
'description' => $this->faker->paragraph(),
'status' => $this->faker->unique()->randomElement(range('A', 'Z')),
'brand_image' => $this->faker->word(),
'bg_color' => $this->faker->word(),
        ];
    }
}
