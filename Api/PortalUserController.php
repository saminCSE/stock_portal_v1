<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PortalUser;
use App\Http\Requests\PortalUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\Models\Token;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Password;

class PortalUserController extends Controller
{
    public function RegisterPortalUser(PortalUserRequest $request)
    {
        $formdata = [
            'full_name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'password' => Hash::make($request->input('password')),
        ];
        $data = PortalUser::create($formdata);
        $data['success'] = 'Registration successfully completed.You can sign in now!';
        return response()->json($data, 200);
    }

    public function login(Request $request)
    {
        if ($request->third_party_apps) {

            if ($request->auth_token) {
                $auth_token_encrypt = $request->auth_token;
                $auth_token = Crypt::decrypt($auth_token_encrypt);
                $user = PortalUser::select('id', 'full_name')->where('api_token', $auth_token)->first();

            } else {

                $validator = $this->validateLoginApiTokenRequest($request);

                if ($validator->fails()) {
                    return response()->json([
                        'data' => $validator->errors(),
                        'status' => 'error',
                    ], 422);
                }

                $credentials = $request->only('email', 'api_token');
                $credentials['api_token'] = urldecode($credentials['api_token']);
                $user = PortalUser::select('id', 'full_name')->where('email', $credentials['email'])->where('api_token', $credentials['api_token'])->first();
            }

            if ($user) {

              
                $tokenid = (string) Str::uuid();
                $token_sha256 = hash('sha256', $tokenid);
                $user->update([
                    'api_token' => $token_sha256,
                ]);

                $response_user = [
                    'id' => $user->id,
                    'full_name' => $user->full_name,
                    'auth_token' => Crypt::encrypt($token_sha256)
                ];


                $response = array(
                    'data' => $response_user,
                    'status' => 'success',
                );
                return response()->json($response);
            } else {
                $response = array(
                    'data' => [],
                    'status' => 'error',
                );
                return response()->json($response);
            }
        } else {
            $validator = $this->validateLoginRequest($request);

            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->errors(),
                    'status' => 'error',
                ], 422);
            }
            $credentials = $request->only('email', 'password');
            if (Auth::guard('portal_user')->attempt($credentials)) {
                $tokenid = (string) Str::uuid();

                $user = Auth::guard('portal_user')->user();

                $response_user = [
                    'id' => $user->id,
                    'full_name' => $user->full_name
                ];
                $token_sha256 = hash('sha256', $tokenid);
                $user->update([
                    'api_token' => $token_sha256,
                ]);

                $response_user['auth_token'] = Crypt::encrypt($token_sha256);
                $response = array(
                    'data' => $response_user,
                    'status' => 'success',
                );
                return response()->json($response);
            } else {
                $response = array(
                    'data' => [],
                    'status' => 'error',
                );
                return response()->json($response);
            }
        }
    }

    private function validateLoginRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'email' => 'required|email|max:200',
            'password' => 'required',
        ]);
    }
    private function validateLoginApiTokenRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'email' => 'required|email|max:200',
            'api_token' => 'required',
        ]);
    }


    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email|max:200',
    //         'password' => 'required',
    //     ]);

    //     if ($validator->fails()) {

    //         $response = array(
    //             'data'=> $validator->errors(),
    //             'status'=>'error',
    //         );
    //         return response()->json([$response],422);
    //     }
    //     $credentials = $request->only('email', 'password');
    //     if (Auth::guard('portal_user')->attempt($credentials)) {
    //         $tokenid = (string) Str::uuid();
    //         $client = new Client();
    //         $response = $client->get('https://api.ipify.org?format=json');
    //         $ipData = json_decode($response->getBody()->getContents(), true);
    //         $ipAddress = $ipData['ip'];
    //         $user = Auth::guard('portal_user')->user();
    //         $user->update([
    //             'api_token' => hash('sha256', $tokenid),
    //             'ip_address' => $ipAddress,
    //         ]);
    //         $response = array(
    //             'data'=>$user,
    //             'status'=>'success',
    //         );
    //         return response()->json($response);
    //     } 
    // }
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function logout(Request $request)
    {
        $user = Auth::guard('portal_user')->user();
        $user->update([
            'api_token' => null,
            // 'ip_address' => null,
        ]);
        Auth::guard('portal_user')->logout();
        return response()->json([
            'message' => 'Logout successful',
        ]);
    }
}
