<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $search = $request->query('search');

        if ($search) {
            return Book::where('title', 'ilike', "%$search%")
                ->orWhere('author', 'ilike', "%$search%")
                ->paginate(15);
        }

        return Book::paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        return Book::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): Response
    {
        return Book::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): Response
    {
        $book = Book::find($id);
        $book->update($request->all());

        return $book;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): Response
    {
        Book::destroy($id);

        return response("Book at id of $id is successfully deleted.", 200);
    }
}
