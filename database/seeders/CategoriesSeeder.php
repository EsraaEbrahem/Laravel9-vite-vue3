<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => "Gifts",
            'is_active' => true,
            'weight' => rand(1, 10),
            'created_by' => 1,
        ]);

        Category::create([
            'name' => "Electronics",
            'is_active' => true,
            'weight' => rand(1, 10),
            'created_by' => 1,
        ]);
    }
}
