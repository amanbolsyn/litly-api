<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\Publisher\StorePublisherRequest;
use App\Http\Requests\Api\v1\Publisher\UpdatePublisherRequest;
use App\Http\Resources\Api\v1\PublisherResource;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return PublisherResource::collection(Publisher::paginate($request->per_page ?? 10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePublisherRequest $request)
    {
        $publisherAttr = collect($request->only(['publisher']))->toArray();

        return new PublisherResource(Publisher::create($publisherAttr));
    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher)
    {
        return new PublisherResource($publisher);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePublisherRequest $request, Publisher $publisher)
    {
        $publisherAttr = collect($request->only(['publisher']))->toArray();

        $publisher->update($publisherAttr);

        return new PublisherResource($publisher);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return response()->json([
            "message" => "resource was successfully deleted",
        ], 200);
    }
}
