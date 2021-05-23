<?php

namespace Tests\Unit;

use App\Repository\BookRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class BookControllerTest extends TestCase
{

    private $_books = [
        [
            "id" => 1,
            "title" => "Nice Book Title",
            "author" => "Dr. Jedidiah Haag Jr.",
            "created_at" => "2021-05-21T12:16:51.000000Z",
            "updated_at" => "2021-05-21T12:16:51.000000Z"
        ],
        [
            "id" => 2,
            "title" => "Nice Second Book Title",
            "author" => "Dr. Jedidiah Haag Jr.",
            "created_at" => "2021-05-21T12:16:51.000000Z",
            "updated_at" => "2021-05-21T12:16:51.000000Z"
        ],
    ];
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->instance(
            BookRepositoryInterface::class,
            Mockery::mock(
                BookRepositoryInterface::class,
                function (MockInterface $mock) {
                    $mock->shouldReceive('all')
                        ->andReturn($this->_books);
                }
            )
        );

        $response = $this->get('api/books');

        $response->assertJson($this->_books);
        $response->assertStatus(200);
    }
}
