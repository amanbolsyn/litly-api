<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\Organization\StoreOrganizationRequest;
use App\Http\Requests\Api\v1\Organization\UpdateOrganizationRequest;
use App\Http\Resources\Api\v1\OrganizationResource;
use App\Models\File;
use App\Models\Organization;
use App\Services\FileStorageService;
use Illuminate\Http\Request;

class OrganizationController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $reqeust)
    {
        return OrganizationResource::collection(Organization::with('files')->paginate($request->per_page ?? 10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrganizationRequest $request, FileStorageService $fileService)
    {
        $orgzAttr = collect($request->only([
            'organization',
            'city',
            'address',
            'allow_purcase',
            'allow_borrow',
            'allow_borrow_days'
        ]))->toArray();

        $organization = Organization::create($orgzAttr);
        if ($request->hasFile('images.logo')) {
            $fileService->uploadAll($request->file('images.logo'), $organization, 'organizations');
        }

        return new OrganizationResource($organization->load('files'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization)
    {
        return new OrganizationResource($organization->load('files'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrganizationRequest $request, Organization $organization, FileStorageService $fileService)
    {

        $orgzAttr = collect($request->only([
            'organization',
            'city',
            'address',
            'allow_purcase',
            'allow_borrow',
            'allow_borrow_days'
        ]))->toArray();

        $organization->update($orgzAttr);

        if ($request->hasFile('images.logo')) {

            $images = $organization->files()->get()->toArray();
            if ($images) {
                $fileService->deleteAll($images);
                File::destroy($images);
            }

            $fileService->uploadAll($request('images.logo'), $organization, 'organizations');
        }

        return new OrganizationResource($organization->load('files'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization, FileStorageService $fileService)
    {
        $fileService->deleteAll($organization->files);
        $organization->delete();

        return response()->json([
            "message" => "resource was successfully deleted",
        ], 200);
    }
}
