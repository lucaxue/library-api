<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $search = $request->query('search');

        if ($search) {
            $books = Book::where('title', 'ilike', "%$search%")
                ->orWhere('author', 'ilike', "%$search%")
                ->paginate(15);
        }

        $books = Book::paginate(15);

        return response($books);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required'
        ]);

        $book = Book::create($request->all());

        return response($book);
    }

    /**
     * Display the specified resource.
     * 
     * @param int $id
     * @return Illuminate\Http\Response
     */
    public function show(int $id): Response
    {
        $book = Book::find($id);

        return response($book);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, int $id): Response
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required'
        ]);

        $book = Book::find($id);
        $book->update($request->all());

        return response($book);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id
     * @return Illuminate\Http\Response
     */
    public function destroy(int $id): Response
    {
        Book::destroy($id);

        return response("Book at id of $id is successfully deleted.");
    }
}
