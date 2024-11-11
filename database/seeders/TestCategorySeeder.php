<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class TestCategorySeeder extends Seeder
{
    public function run()
    {
        // Asegura la existencia de la categoría con id 1 sin borrar otras
        Category::firstOrCreate(['id' => 1], ['name' => 'Default Category']);
    }
}
