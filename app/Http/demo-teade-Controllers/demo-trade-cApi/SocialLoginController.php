<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Google_Client;
use Google_Service_Oauth2;

class SocialLoginController extends Controller
{
    public function googleLogin(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $googleToken = $googleUser->token;
            $accessToken=$request->input($googleToken);
            $existingUser = User::where('google_id', $googleUser->getId())->first();

            $email = $existingUser->getEmail();
            $authenticatedUser = User::where('email', $email)->first();

            if ($authenticatedUser) {
                auth()->login($authenticatedUser);
                $accessToken = Str::random(60);
                $authenticatedUser->api_token = hash('sha256', $accessToken);
                $authenticatedUser->save();
                
                return response()->json([
                    'token' => $accessToken,
                    'user' => $authenticatedUser,
                ]);
            } else {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }
    }
}
