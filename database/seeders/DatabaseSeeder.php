<?php

namespace Database\Seeders;

use App\Models\Word;
use App\Models\WordCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $wordCategoryIds = [];
        foreach (fastexcel()->import(__DIR__.'/data/word_categories.csv') as $row) {
            $wordCategoryIds[$row['id']] = WordCategory::firstOrCreate([
                'name' => $row['name'],
            ])->id;
        }

        foreach (fastexcel()->import(__DIR__.'/data/words.csv') as $row) {
            Word::firstOrCreate(
                [
                    'name' => $row['name'],
                ],
                [
                    'word_category_id' => $wordCategoryIds[$row['word_category_id']],
                    'difficulty' => $row['difficulty'],
                ],
            );
        }
    }
}
