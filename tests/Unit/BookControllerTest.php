<?php

namespace Tests\Unit;

use App\Repository\BookRepositoryInterface;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    protected $books = [
        [
            "id" => 1,
            "title" => "Nice Book Title",
            "author" => "Dr. Jedidiah Haag Jr.",
            "created_at" => "2021-05-21T12:16:51.000000Z",
            "updated_at" => "2021-05-21T12:16:51.000000Z",
        ],
        [
            "id" => 2,
            "title" => "Nice Second Book Title",
            "author" => "Dr. Jedidiah Haag Jr.",
            "created_at" => "2021-05-21T12:16:51.000000Z",
            "updated_at" => "2021-05-21T12:16:51.000000Z",
        ],
    ];

    /** @test */
    public function it_can_index_books()
    {
        $repository = $this->createMock(BookRepositoryInterface::class);
        $this->instance(BookRepositoryInterface::class, $repository);

        $repository->expects($this->once())
            ->method('all')
            ->willReturn($this->books);

        $response = $this->get('api/books');
        $response->assertJson($this->books);
        $response->assertStatus(200);
    }
}
