<?php

namespace Database\Factories;

use App\Models\AgeGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgeGroupFactory extends Factory
{
    protected $model = AgeGroup::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'min_age' => $this->faker->randomElement([5, 9, 14, 16]),
            'max_age' => $this->faker->randomElement([8, 13, 16, 99]), // Valores que reflejan los rangos correspondientes
        ];
    }
}
