<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\Session\StoreSessionRequest;
use App\Http\Resources\Api\v1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SessionController extends Controller
{
    public function store(StoreSessionRequest $request)
    {

        $user = User::firstWhere('email', $request["email"]);

        if (!Hash::check($request["password"], $user->password)) {
            return response()->json([
                "message" => "Invalid credentials"
            ], 401);
        }

        return response()->json([
            "message" => "authenticated",
            "token" => $user->createToken('token' . $user->email, ['*'],  now()->plus(minutes: 40))->plainTextToken,
            "data" => new UserResource($user),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "message" => "logged out"
        ], 200);
    }
}
