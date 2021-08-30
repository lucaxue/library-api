<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BooksApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_gets_all_books()
    {
        $books = Book::factory()->count(10)->create();

        $this->getJson('api/books')
            ->assertOk()
            ->assertExactJson($books->toArray());
    }

    /** @test */
    public function it_paginates_books_by_15_items()
    {
        $books = Book::factory()->count(30)->create();

        $this->getJson('api/books')
            ->assertOk()
            ->assertJsonCount(15)
            ->assertExactJson($books->take(15)->toArray());

        $this->getJson('api/books?page=2')
            ->assertOk()
            ->assertJsonCount(15)
            ->assertExactJson([...$books->take(-15)->toArray()]);

        $this->getJson('api/books?page=3')
            ->assertOk()
            ->assertJsonCount(0)
            ->assertExactJson([]);
    }

    /** @test */
    public function it_searches_for_books_by_title_and_author()
    {
        Book::factory()->count(30)->create();
        $books = collect([
            Book::factory()->create(['title' => 'QUERY']),
            Book::factory()->create(['author' => 'QUERY']),
            Book::factory()->create(['title' => 'query']),
            Book::factory()->create(['author' => 'query']),
            Book::factory()->create(['title' => 'helloqueryhello']),
            Book::factory()->create(['author' => 'helloqueryhello']),
        ]);

        $this->getJson('api/books?search=query')
            ->assertOk()
            ->assertJsonCount(6)
            ->assertExactJson($books->toArray());
    }

    /** @test */
    public function it_gets_book_by_id()
    {
        $this->getJson('api/books/5')
            ->assertNotFound()
            ->assertExactJson(['error' => 'book of id 5 does not exist.']);

        Book::factory()->create(['id' => 5]);

        $this->getJson('api/books/5')
            ->assertOk()
            ->assertJson(fn ($json) => $json
                ->where('id', 5)
                ->etc()
            );
    }
}
