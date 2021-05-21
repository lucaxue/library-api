<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repository\BookRepositoryInterface;

class BookController extends Controller
{
    private BookRepositoryInterface $_userRepository;

    public function __construct(BookRepositoryInterface $userRepository)
    {
        $this->_userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = $request->query('search');

        $books = $query ?
            $this->_userRepository->search($query) :
            $this->_userRepository->all();

        return response()->json($books, 200);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required'
        ]);

        $book = $this->_userRepository->create($request->all());

        return response()->json($book, 200);
    }

    /**
     * Display the specified resource.
     * 
     * @param int $id
     * @return Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $book = $this->_userRepository->findById($id);

        return response()->json($book, 200);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required'
        ]);

        $book = $this->_userRepository->update($request->all(), $id);

        return response()->json($book, 200);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id
     * @return Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $isDeleted = $this->_userRepository->deleteById($id);

        $message =  $isDeleted ?
            [["success" => "book of id $id has been deleted."], 200] :
            [["error" => "book of id $id does not exist."], 400];

        return response()->json(...$message);
    }
}
