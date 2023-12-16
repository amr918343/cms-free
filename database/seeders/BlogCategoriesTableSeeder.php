<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        BlogCategory::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $categories = json_decode(file_get_contents(database_path('seeders/SeedData/blog_categories.json')), true);

        foreach ($categories as $category) {
            BlogCategory::create([
                'title' => ['en' => $category['en'], 'ar' => $category['ar']],
            ]);
        }
    }
}
