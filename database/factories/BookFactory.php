<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Book;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    protected $titles = [
        'The Great Gatsby', 'To Kill a Mockingbird', '1984', 'Pride and Prejudice', 'The Catcher in the Rye',
        'The Lord of the Rings', 'Animal Farm', 'The Hobbit', 'Brave New World', 'The Chronicles of Narnia',
        'Harry Potter and the Philosopher\'s Stone', 'Fahrenheit 451', 'The Da Vinci Code', 'The Hitchhiker\'s Guide to the Galaxy',
        'Moby-Dick', 'The Grapes of Wrath', 'One Hundred Years of Solitude', 'The Picture of Dorian Gray', 'Wuthering Heights',
        'Don Quixote', 'Crime and Punishment', 'The Adventures of Huckleberry Finn', 'Dracula', 'Jane Eyre'
    ];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
 
        

        return [
            'title' => $this->faker->randomElement($this->titles),
            'description' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(),
            'author_id' => \App\Models\Author::factory()->create()->id,
            'category_id' => \App\Models\Category::factory()->create()->id,
            'price' => $this->faker->randomFloat(2, 5, 100),
            'sale_price' => $this->faker->optional(0.5)->randomFloat(2, 3, 50), // 50% chance of being null
            'publishing_house_id' => \App\Models\PublishingHouse::factory()->create()->id,
            'published_year' => $this->faker->numberBetween(1800, (int)date('Y')), // Random year between 1800 and current year
        ];
    }
}
