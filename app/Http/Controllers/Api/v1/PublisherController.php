<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\Publisher\StorePublisherRequest;
use App\Http\Requests\Api\v1\Publisher\UpdatePublisherRequest;
use App\Http\Resources\Api\v1\PublisherResource;
use App\Models\File;
use App\Models\Publisher;
use App\Services\FileStorageService;
use Illuminate\Http\Request;

class PublisherController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return PublisherResource::collection(Publisher::with('files')->paginate($request->per_page ?? 10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePublisherRequest $request, FileStorageService $fileService)
    {
        $publisherAttr = collect($request->only(['publisher']))->toArray();

        $publisher = Publisher::create($publisherAttr);

        if ($request->hasFile('images.logo')) {
            $fileService->uploadAll($request->file('images.logo'), $publisher, 'publishers');
        }

        return new PublisherResource($publisher->load('files'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher)
    {
        return new PublisherResource($publisher->load('files'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePublisherRequest $request, Publisher $publisher, FileStorageService $fileService)
    {
        $publisherAttr = collect($request->only(['publisher']))->toArray();

        $publisher->update($publisherAttr);

        if ($request->hasFile('images.logo')) {
            
            $images = $publisher->files()->get()->toArray();
            if ($images) {
                $fileService->deleteAll($images);
                File::destroy($images);
            }

            $fileService->uploadAll($request('images.logo'), $publisher, 'publishers');
        }

        return new PublisherResource($publisher->load('files'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher, FileStorageService $fileService)
    {
        $fileService->deleteAll($publisher->files);
        $publisher->delete();

        return response()->json([
            "message" => "resource was successfully deleted",
        ], 200);
    }
}
