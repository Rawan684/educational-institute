<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Cache;
use App\Notifications\EmailVerificationNotification;
use App\Traits\HttpResponses;
use Illuminate\Support\Str;
use App\Models\User;

class registerController extends Controller
{
    use HttpResponses;

    public function register(StoreUserRequest $request)
    {

        try {
            $request->validated($request->all());
            $user = new User();
            $user->email = $request->input('email');
            $user->name = $request->input('name');
            $user->password = Hash::make($request->input('password'));

            $user->save();
            $token = $user->createToken('Api Token Of ' . $user->name)->plainTextToken;

            return $this->success([
                'user' => $user,
                'token' => $token
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function confirmEmailVerificationCode(User $user, Request $request)
    {
        // Retrieve the verification code from the request
        $code = $request->input('code');

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Check if the verification code is valid
        if ($code === Cache::get('email_verification_' . $user->id)) {
            // Mark the user's email as verified
            $user->email_verified_at = now();
            $user->save();

            return response()->json(['message' => 'Email verified successfully'], 200);
        } else {
            return response()->json(['message' => 'Invalid verification code'], 422);
        }
        // Remove the verification code from the cache
        Cache::forget('email_verification_' . $user->id);

        // Store the user's IP address in the cache
        $ipAddress = $request->ip();
        Cache::put('user_ip_' . $user->id, $ipAddress, now()->addMinutes(30));

        return response()->json(['message' => 'Email verified successfully.'], 200);
    }



    private function sendEmailVerificationCode(User $user)
    {
        $code = Str::random(6, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
        // $code = rand(100000, 999999);
        Cache::put('email_verification_code_' . $user->id, $code, now()->addMinutes(30));
        echo $code;
        $user->notify(new EmailVerificationNotification($user,  $code));
    }
}
