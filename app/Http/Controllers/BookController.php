<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
        $query = Book::query();

        if ($request->filled('search')) {
            $query->where(function ($query) use ($request) {
                $query
                    ->where('title', 'LIKE', '%'.$request->get('search').'%')
                    ->orWhere('author', 'LIKE', '%'.$request->get('search').'%');
            });
        }

        return response()->json($query->paginate($request->get('per_page', 50)));
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
