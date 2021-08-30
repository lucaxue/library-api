<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\Eloquent\BookRepository;

class BookController extends Controller
{
    public function __construct(
        private BookRepository $repository
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        if ($request->has('search')) {
            return response()->json($this->repository->search($request->query('search')));
        }

        return response()->json($this->repository->all());
    }

    public function store(Request $request): JsonResponse
    {
        $book = $this->repository->create($request->validate([
            'title' => 'required',
            'author' => 'required'
        ]));

        return response()->json($book, JsonResponse::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        $book = $this->repository->findById($id);

        if (!$book) {
            return response()->json(
                ["error" => "book of id $id does not exist."],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        return response()->json($book);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $book = $this->repository->update($request->validate([
            'title' => 'required',
            'author' => 'required'
        ]), $id);

        return response()->json($book);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->repository->deleteById($id);

        if (!$deleted) {
            return response()->json(
                ["error" => "book of id $id does not exist."],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        return response()->json(["success" => "book of id $id has been deleted."]);
    }
}
