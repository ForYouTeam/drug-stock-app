<?php

namespace Database\Factories;

use App\Models\Drug;
use Bezhanov\Faker\Provider\Medicine;
use Illuminate\Database\Eloquent\Factories\Factory;

class DrugFactory extends Factory
{
    protected $model = Drug::class;

    public function definition()
    {
        $this->faker->addProvider(new Medicine($this->faker));

        return [
            'name' => $this->faker->unique()->medicine,
        ];
    }
}
