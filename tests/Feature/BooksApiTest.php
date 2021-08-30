<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
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
    public function it_paginates_books_by_15()
    {
        $books = Book::factory()->count(30)->create();

        $this->getJson('api/books')
            ->assertOk()
            ->assertJsonCount(15)
            ->assertExactJson($books->take(15)->toArray());
    }

    /** @test */
    public function it_returns_the_first_page_of_books_implicitly()
    {
        $books = Book::factory()->count(15)->create();

        $this->getJson('api/books')
            ->assertExactJson($books->toArray());

        $this->getJson('api/books?page=1')
            ->assertExactJson($books->toArray());
    }


    /** @test */
    public function it_returns_correct_books_per_page()
    {
        $books = Book::factory()->count(25)->create();

        $this->getJson('api/books?page=1')
            ->assertOk()
            ->assertJsonCount(15)
            ->assertExactJson($books->take(15)->toArray());

        $this->getJson('api/books?page=2')
            ->assertOk()
            ->assertJsonCount(10)
            ->assertExactJson([...$books->take(-10)->toArray()]);
    }


    /** @test */
    public function it_searches_for_books_by_title_and_author()
    {
        Book::factory()->count(30)->create();

        $books = collect([
            Book::factory()->create(['title' => 'QUERY']),
            Book::factory()->create(['title' => 'query']),
            Book::factory()->create(['title' => 'helloqueryhello']),

            Book::factory()->create(['author' => 'QUERY']),
            Book::factory()->create(['author' => 'query']),
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
        $book = Book::create([
            'id' => 5,
            'title' => 'Title',
            'author' => 'John Doe'
        ]);

        $this->getJson('api/books/5')
            ->assertOk()
            ->assertExactJson($book->toArray());
    }

    /** @test */
    public function it_returns_not_found_when_getting_book_with_invalid_id()
    {
        $this->getJson('api/books/5')
            ->assertNotFound()
            ->assertExactJson(['error' => 'book of id 5 does not exist.']);
    }

    /** @test */
    public function it_stores_a_new_book()
    {
        $this->postJson('api/books', $book = ['title' => 'Title', 'author' => 'John Doe'])
            ->assertCreated()
            ->assertJson($book);

        $this->assertDatabaseHas('books', $book);
    }

    /** @test */
    public function it_requires_both_title_and_author_when_storing_a_book()
    {
        $this->postJson('api/books', [])
            ->assertJsonValidationErrors(['title', 'author']);

        $this->postJson('api/books', ['title' => 'Title'])
            ->assertJsonValidationErrors(['author']);

        $this->postJson('api/books', ['author' => 'John Doe'])
            ->assertJsonValidationErrors(['title']);
    }

    /** @test */
    public function it_updates_an_existing_book_by_id_and_data()
    {
        Book::create($originalBook = [
            'id' => 5,
            'title' => 'Original Title',
            'author' => 'Original Author'
        ]);

        $this->putJson('api/books/5', $newBook = ['title' => 'New Title', 'author' => 'New Author'])
            ->assertOk()
            ->assertJson($newBook);

        $this->assertDatabaseHas('books', $newBook);
        $this->assertDatabaseMissing('books', $originalBook);
    }

    /** @test */
    public function it_requires_both_title_and_author_when_updating_a_book()
    {
        Book::factory()->create(['id' => 5]);

        $this->putJson('api/books/5', [])
            ->assertJsonValidationErrors(['title', 'author']);

        $this->putJson('api/books/5', ['title' => 'Title'])
            ->assertJsonValidationErrors(['author']);

        $this->putJson('api/books/5', ['author' => 'John Doe'])
            ->assertJsonValidationErrors(['title']);
    }

    /** @test */
    public function it_deletes_an_existing_book_by_id()
    {
        $book = Book::factory()->create(['id' => 5]);

        $this->deleteJson('api/books/5')
            ->assertOk()
            ->assertExactJson(["success" => "book of id 5 has been deleted."]);

        $this->assertDatabaseMissing('books', $book->toArray());
    }

    /** @test */
    public function it_returns_not_found_when_deleting_a_non_existent_book()
    {
        $this->deleteJson('api/books/5')
            ->assertNotFound()
            ->assertExactJson(["error" => "book of id 5 does not exist."]);
    }
}
