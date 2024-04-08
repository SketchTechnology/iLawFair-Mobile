<?php

namespace Database\Seeders;
use App\Models\Category;
use App\Models\Author;
use App\Models\PublishingHouse;
use App\Models\Book;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(AdminSeeder::class);
        //  Category::factory()->count(30)->create();
        // Author::factory()->count(30)->create();
        // PublishingHouse::factory()->count(20)->create();
        Book::factory()->count(50)->create();


    }
}
