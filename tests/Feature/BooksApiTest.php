<?php

namespace Tests\Feature;

use App\Models\Book\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BooksApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_retrieves_books()
    {
        $books = Book::factory(10)->create();

        $this
            ->getJson('api/books')
            ->assertOk()
            ->assertJsonFragment(['total' => 10])
            ->assertJson(['data' => $books->toArray()]);
    }

    /** @test */
    public function it_paginates_books()
    {
        $books = Book::factory(10)->create();

        $this
            ->json('GET', 'api/books', ['page' => 2, 'per_page' => 5])
            ->assertOk()
            ->assertJsonFragment(['current_page' => 2])
            ->assertJsonFragment(['per_page' => 5])
            ->assertJsonFragment(['from' => 6])
            ->assertJsonFragment(['to' => 10])
            ->assertJson(['data' => $books->take(-5)->values()->toArray()]);
    }

    /** @test */
    public function it_searches_books()
    {
        $books = Book::factory(3)->sequence(
            ['title' => 'Thinking, Fast and Slow'],
            ['author' => 'John Minks'],
            ['title' => 'Atomic Habits'],
        )->create();

        $this
            ->json('GET', 'api/books', ['search' => 'ink'])
            ->assertOk()
            ->assertJsonFragment(['total' => 2])
            ->assertJsonFragment($books[0]->toArray())
            ->assertJsonFragment($books[1]->toArray());
    }

    /** @test */
    public function it_retrieves_books_by_id()
    {
        $books = Book::factory(3)->create();

        $this
            ->json('GET', 'api/books', ['id' => $books[0]->id.','.$books[2]->id])
            ->assertOk()
            ->assertJsonFragment(['total' => 2])
            ->assertJsonFragment($books[0]->toArray())
            ->assertJsonFragment($books[2]->toArray());
    }

    /** @test */
    public function it_retrieves_an_existing_book()
    {
        $book = Book::factory()->create();

        $this
            ->getJson('api/books/'.$book->id)
            ->assertOk()
            ->assertExactJson($book->toArray());
    }

    /** @test */
    public function it_cannot_retrieve_unknown_books()
    {
        $this
            ->getJson('api/books/'.rand())
            ->assertNotFound();
    }

    /** @test */
    public function it_creates_a_book()
    {
        $json = $this
            ->postJson('api/books', [
                'title' => 'My Book',
                'author' => 'John Doe',
            ])
            ->assertCreated()
            ->assertJsonStructure(['id'])
            ->getData();

        $this->assertDatabaseHas(Book::class, [
            'id' => $json->id,
            'title' => 'My Book',
            'author' => 'John Doe',
        ]);
    }

    /** @test */
    public function it_guards_against_missing_fields()
    {
        $this
            ->postJson('api/books', [])
            ->assertJsonValidationErrors(['title', 'author']);

        $this
            ->postJson('api/books', ['title' => 'My Book'])
            ->assertJsonValidationErrors(['author']);

        $this
            ->postJson('api/books', ['author' => 'John Doe'])
            ->assertJsonValidationErrors(['title']);
    }

    /** @test */
    public function it_updates_an_existing_book()
    {
        $book = Book::factory()->create([
            'title' => 'My Book',
            'author' => 'John Doe',
        ]);

        $this
            ->putJson('api/books/'.$book->id, [
                'title' => 'The Book',
                'author' => 'John James Doe',
            ])
            ->assertNoContent();

        $this->assertDatabaseHas(Book::class, [
            'id' => $book->id,
            'title' => 'The Book',
            'author' => 'John James Doe',
        ]);
    }

    /** @test */
    public function it_deletes_an_existing_book()
    {
        $book = Book::factory()->create();

        $this
            ->deleteJson('api/books/'.$book->id)
            ->assertNoContent();

        $this->assertDeleted($book);
    }

    /** @test */
    public function it_cannot_delete_unknown_books()
    {
        $this
            ->deleteJson('api/books/'.rand())
            ->assertNotFound();
    }
}
