<?php

namespace App\Http\Controllers;

use App\Http\Requests\RetrieveBooksRequest;
use App\Models\Book\Book;
use App\Models\Book\BookFinder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function store(Request $request) : JsonResponse
    {
        $attributes = $request->validate([
            'title' => 'required',
            'author' => 'required',
        ]);

        $book = Book::create($attributes);

        return response()->json(['id' => $book->id], JsonResponse::HTTP_CREATED);
    }

    public function show(Book $book) : JsonResponse
    {
        return response()->json($book);
    }

    public function update(
        Request $request,
        Book $book
    ) : JsonResponse {

        $attributes = $request->validate([
            'title' => 'required',
            'author' => 'required',
        ]);

        $book->update($attributes);

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }

    public function destroy(Book $book) : JsonResponse
    {
        $book->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
