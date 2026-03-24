<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\User\UpdateUserReqeust;
use App\Http\Resources\Api\v1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return UserResource::collection(User::with('roles')->paginate($request->per_page ?? 10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserReqeust $request, User $user)
    {
        $userAttr = collect($request->only(['fullname']))->toArray();

        $user->update($userAttr); 

        return new UserResource($user); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
