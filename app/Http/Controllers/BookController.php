<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repository\BookRepositoryInterface;

class BookController extends Controller
{
    private BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function index(Request $request): JsonResponse
    {
        if ($request->has('search')) {
            return response()->json($this->bookRepository->search($request->query('search')));
        }

        return response()->json($this->bookRepository->all());
    }

    public function store(Request $request): JsonResponse
    {
        $book = $this->bookRepository->create($request->validate([
            'title' => 'required',
            'author' => 'required'
        ]));

        return response()->json($book, JsonResponse::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        $book = $this->bookRepository->findById($id);

        if (! $book) {
            return response()->json(
                ["error" => "book of id $id does not exist."],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        return response()->json($book);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $book = $this->bookRepository->update($request->validate([
            'title' => 'required',
            'author' => 'required'
        ]), $id);

        return response()->json($book);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->bookRepository->deleteById($id);

        if (! $deleted) {
            return response()->json(
                ["error" => "book of id $id does not exist."],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        return response()->json(["success" => "book of id $id has been deleted."]);
    }
}
