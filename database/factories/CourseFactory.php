<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\AgeGroup;


class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'category_id' => Category::first()->id ?? Category::factory(),
            'age_group_id' => AgeGroup::first()->id ?? AgeGroup::factory(),
        ];
    }
}
