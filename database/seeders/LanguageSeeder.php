<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            'Arabic',
            'English',
            'French',
            'German',
            'Italian',
            'Japanese',
            'Korean',
            'Portuguese(Brazil)',
            'Portuguese(Portugal)',
            'Russian',
            'Spanish',
        ];

        foreach($languages as $language)
        {
            Language::create([
                'name' => $language
            ]);
        }
    }
}
