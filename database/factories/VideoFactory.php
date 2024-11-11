<?php

namespace Database\Factories;

use App\Models\Video;
use App\Models\Course;

use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    protected $model = Video::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'subtitle' => $this->faker->sentence,
            'url' => $this->faker->url,
            'duration' => $this->faker->numberBetween(5, 120),
            'course_id' => Course::factory(), // Se crea un curso si no existe
            'description' => $this->faker->paragraph,
        ];
    }
}
