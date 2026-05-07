<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\Author\UpdateAuthorRequest;
use App\Http\Requests\Api\v1\Author\StoreAuthorReqeust;
use App\Http\Resources\Api\v1\AuthorResource;
use App\Models\Author;
use App\Models\File;
use App\Services\FileStorageService;
use Illuminate\Http\Request;

class AuthorController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return AuthorResource::collection(Author::with('files')->paginate($request->per_page ?? 10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorReqeust $request, FileStorageService $fileService)
    {
        $authorAttr = collect($request->only([
            'fullname',
            'biography',
            'languages',
            'date_of_birth',
            'date_of_death'
        ]))->toArray();

        $author = Author::create($authorAttr);

        if ($request->hasFile('images.portrait')) {
            $fileService->uploadAll($request->file('images.portrait'), $author, 'authors');
        }

        return new AuthorResource($author);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return new AuthorResource($author->load('files'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Author $author, FileStorageService $fileService)
    {
        $authorAttr = collect($request->only([
            'fullname',
            'biography',
            'languages',
            'date_of_birth',
            'date_of_death'
        ]))->toArray();

        $author->update($authorAttr);

        $currentImages = $author->files()->pluck('id')->toArray();
        $keptImages = collect($request->input('images.portrait.old'))->toArray();
        $imagesToDelete = array_diff($currentImages, $keptImages);

        if ($imagesToDelete) {
            $images = $author->files()->whereIn('id', $imagesToDelete)->get()->toArray();
            $fileService->deleteAll($images);
            File::destroy($imagesToDelete);
        }

        if ($request->hasFile('images.portrait.new')) {
            $fileService->uploadAll($request->file('images.portrait.new'), $author, 'authors',);
        }

        return new AuthorResource($author->load('files'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author, FileStorageService $fileService)
    {

        $fileService->deleteAll($author->files);
        $author->delete();

        return response()->json([
            "message" => "resource was successfully deleted",
        ], 200);
    }
}
