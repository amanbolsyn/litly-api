<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\Organization\StoreOrganizationRequest;
use App\Http\Requests\Api\v1\Organization\UpdateOrganizationRequest;
use App\Http\Resources\Api\v1\OrganizationResource;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $reqeust)
    {
        return OrganizationResource::collection(Organization::paginate($request->per_page ?? 10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrganizationRequest $request)
    {
        $orgzAttr = collect($request->only([
            'organization',
            'city',
            'address',
            'allow_purcase',
            'allow_borrow',
            'allow_borrow_days'
        ]))->toArray();

        return new OrganizationResource( Organization::create($orgzAttr));
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization)
    {
        return new OrganizationResource($organization);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrganizationRequest $request, Organization $organization)
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

        return new OrganizationResource($organization); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
    {
        $organization->delete();

        return response()->json([
            "message" => "resource was successfully deleted",
        ], 200);
    }
}
