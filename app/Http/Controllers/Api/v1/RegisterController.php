<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\Auth\RegisterUserRequest;
use App\Http\Resources\Api\v1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordValidate;
use Pest\Support\Str;

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

      public function verifyEmail(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        // Verify if the hash is correct
        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return response()->json(['message' => 'Invalid verification link.'], 403);
        }

        // Mark email as verified
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return response()->json(['message' => 'Email verified successfully!']);
    }

    public function sendVertifiction(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.'], 400);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification link resent!']);
    }


    public function sendResetLink(Request $request)
    {
        $email = $request->validate([
            'email' => ['required', 'email', 'ends_with:@astanait.edu.kz', 'max:255'],
        ]);

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['error' => 'Invalid credentials'], 404);
        }

        $status = Password::sendResetLink(
            $email
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)])
            : response()->json(['message' => __($status)], 400);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' =>  ['required', 'email', 'ends_with:@astanait.edu.kz', 'max:255'],
            'token' => 'required',
            'password' => ["required", "confirmed", PasswordValidate::min(8)->letters()->numbers()->mixedCase()->symbols()]
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => __($status)])
            : response()->json(['message' => __($status)], 400);
    }
}
