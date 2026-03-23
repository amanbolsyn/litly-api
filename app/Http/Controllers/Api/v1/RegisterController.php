<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\Auth\RegisterUserRequest;
use App\Http\Resources\Api\v1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterUserRequest $request)
    {
        $userAttributes = collect($request->only('fullname', 'email', 'password'))->toArray();

        $user = User::create($userAttributes);

        return response()->json([
            "message" => "registered",
            'token' =>  $user->createToken('token' . $user->email, ['*'],  now()->plus(minutes: 40))->plainTextToken, 
            'data' => new UserResource($user), 
        ]);
    }
}
