<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\Book\StoreBookRequest;
use App\Http\Requests\Api\v1\Book\UpdateBookReqeust;
use App\Http\Resources\Api\v1\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return BookResource::collection(Book::with(['authors', 'categories'])->paginate($request->per_page ?? 10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $bookAttr = collect($request->only([
            'title',
            'isbn',
            'description',
            'publication_year',
            'publisher_id'
        ]))->toArray();

        $book = Book::create($bookAttr);

        $book->authors()->attach($request->input('authors'));
        $book->categories()->attach($request->input('categories'));

        if ($request->organization_id) {
            $book->organizations()->attach($request->organization_id, [
                'stock' => $request->stock ?? 0
            ]);
        }

        return new BookResource($book);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return  new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookReqeust $request, Book $book)
    {
        $bookAttr = collect($request->only([
            'title',
            'isbn',
            'description',
            'publication_year',
            'publisher_id'
        ]))->toArray();

        $book->update($bookAttr);

        $book->authors()->sync($request->input('authors'));
        $book->categories()->sync($request->input('categories'));

        if ($request->organization_id) {
            $book->organizations()->sync([
                $request->organization_id => [
                    'stock' => $request->stock ?? 0
                ]
            ]);
        }

        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json([
            "message" => "resource was successfully deleted",
        ], 200);
    }
}
