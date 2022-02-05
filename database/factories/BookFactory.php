<?php

namespace Database\Factories;

use App\Models\Book\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        return [
            'title' => $this->faker->words(3, true),
            'author' => $this->faker->name(),
        ];
    }
}
