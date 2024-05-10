<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Carbon;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function Register()
    {
        return view('page.Registration');
    }
    public function RegisterUser(UserRequest $request)
    {
        $formdata = [
            'full_name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'password' => Hash::make($request->input('password')),
        ];
        $data = User::create($formdata);
        return redirect()->back()
            ->with('success', 'Registration successful. Please log in.');
    }

    public function RedirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function RedirectFacebook()
    {
       return Socialite::driver('facebook')->redirect();
    }
    public function RedirectFacebookCallBack(Request $request)
    {
        try {
            $facebook_user = Socialite::driver('facebook')->user();
            dd($facebook_user);
            $user = User::where('facebook_id', $facebook_user->getId())->first();
            if (!$user) {
                $full_name = $facebook_user->getName();
                $token = (string) Str::uuid();
                $facebookToken = Hash::make($token);
                $new_user = [
                    'full_name' => $full_name,
                    'email' => $facebook_user->getEmail(),
                    'google_id' => $facebook_user->getId(),
                    'api_token' => $facebook_user,
                    'password' => Hash::make($full_name.'@'.$facebook_user->getId()),
                ];
                dd($new_user);
                $data = User::create($new_user);

            } else {
                $facebookToken = $user->api_token;
            }
            $redirectUrl = env('GOOGLE_REDIRECT_URL');
            $redirectUrl .= '?email=' . urlencode($facebook_user->getEmail());
            $redirectUrl .= '&api_token=' . urlencode($facebookToken);
            return redirect($redirectUrl);

        } catch (\Exception $e) {
            return redirect('/')
                ->with('message', 'Error occurred during Facebook callback:');
        }
    }
    public function RedirectGoogleCallBack(Request $request)
    {
        try {
            $google_user = Socialite::driver('google')->user();
            $user = User::where('google_id', $google_user->getId())->first();
            if (!$user) {
                $full_name = $google_user->getName();
                $token = (string) Str::uuid();
                $googleToken = Hash::make($token);
                $new_user = [
                    'full_name' => $full_name,
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId(),
                    'api_token' => $googleToken,
                    'password' => Hash::make($full_name.'@'.$google_user->getId()),
                ];

                $data = User::create($new_user);

            } else {
                $googleToken = $user->api_token;
            }
            $redirectUrl = env('GOOGLE_REDIRECT_URL');
            $redirectUrl .= '?email=' . urlencode($google_user->getEmail());
            $redirectUrl .= '&api_token=' . urlencode($googleToken);
            return redirect($redirectUrl);

        } catch (\Exception $e) {
            return redirect('/')
                ->with('message', 'Error occurred during Google callback:');
        }
    }    
}
