<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AgeGroup;


class TestAgeGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Asegura la existencia del age group con id 1
        AgeGroup::firstOrCreate(
            ['id' => 1],
            ['name' => 'Default Age Group', 'min_age' => '5', 'max_age' => '8']
        );
    }
}
