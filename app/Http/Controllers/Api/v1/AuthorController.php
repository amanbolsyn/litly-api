<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\Author\UpdateAuthorRequest;
use App\Http\Requests\Api\v1\Author\StoreAuthorReqeust;
use App\Http\Resources\Api\v1\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return AuthorResource::collection(Author::paginate($request->per_page ?? 10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorReqeust $request)
    {
        $authorAttr = collect($request->only([
            'fullname',
            'biography',
            'language',
            'date_of_birth',
            'date_of_death'
        ]))->toArray();

        return new AuthorResource(Author::create($authorAttr));
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return new AuthorResource($author);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $authorAttr = collect($request->only([
            'fullname',
            'biography',
            'languages',
            'date_of_birth',
            'date_of_death'
        ]))->toArray();

        $author->update($authorAttr); 

        return new AuthorResource($author); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return response()->json([
            "message" => "resource was successfully deleted",
        ], 200);
    }
}
