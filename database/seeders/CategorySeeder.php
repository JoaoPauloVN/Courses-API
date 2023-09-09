<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Computer Science',
            'Arts and Humanities',
            'Business',
            'Data Science',
            'Health',
            'Information Technology',
            'Language Learning',
            'Math and Logic',
            'Personal Development',
            'Physical Science and Engineering',
            'Social Sciences'
        ];

        foreach($categories as $category)
        {
            Category::create([
                'name' => $category
            ]);
        }
    }
}
