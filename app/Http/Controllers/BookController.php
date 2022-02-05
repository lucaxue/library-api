<?php

namespace App\Http\Controllers;

use App\Http\Requests\RetrieveBooksRequest;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book\Book;
use App\Models\Book\BookFinder;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    public function index(
        BookFinder $finder,
        RetrieveBooksRequest $request,
    ) : JsonResponse {

        $books = $finder->all(
            $request->filters(),
            $request->get('per_page', 50)
        );

        return response()->json($books);
    }

    public function store(StoreBookRequest $request) : JsonResponse
    {
        $book = Book::create($request->validated());

        return response()->json(['id' => $book->id], JsonResponse::HTTP_CREATED);
    }

    public function show(Book $book) : JsonResponse
    {
        return response()->json($book);
    }

    public function update(
        UpdateBookRequest $request,
        Book $book
    ) : JsonResponse {

        $book->update($request->validated());

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }

    public function destroy(Book $book) : JsonResponse
    {
        $book->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
