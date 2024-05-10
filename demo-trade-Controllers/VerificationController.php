<?php

namespace App\Http\Controllers;

use App\Models\PortalUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\VerificationMail;
use App\Mail\PasswordResetMail;
use App\Mail\VerificationPhone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller
{
    public function verify(Request $request)
    {
        $verificationCode = $request->query('key');
        // dd($email, $verificationCode);

        $user = PortalUser::where('email_verification_code', $verificationCode)
            ->first();
        // dd($user, $verificationCode,$email);
        if ($user) {
            $emailVerificationTime = strtotime($user->email_verification_time);
            $currentTimestamp = time();

            $timeDifference = $currentTimestamp - $emailVerificationTime;
            // dd($timeDifference);

            if ($timeDifference > 0) {
                return redirect()->route('verify_timeout')->with('error', 'Validation link expired');
            }

            $user->update(['is_email_verified' => 1]);

            return redirect()->route('verify_successfull')->with('message', 'Account verified successfully!');
        }

        return redirect()->route('verify_invalid')->with('error', 'Invalid verification link.');
    }


    public function verifySuccessfull(){
        return view('demo_trade.verify_successfull');
    }
    public function verifyInvalid(){
        return view('demo_trade.verify_invalid');
    }
    public function verifyTimeout(){
        return view('demo_trade.verify_timeout');
    }


    public function send_email_verification_code()
    {


        $user = Auth::user();


        $user->email_verification_code = Hash::make(Str::random(6));
        $user->email_verification_time = now()->addSeconds(env('OTP_EXPIRED_TIME',300))->toDateTimeString();
        $user->save();

        // Send verification email
        Mail::to($user->email)->send(new VerificationMail($user));



        Session::flash('message', 'Please check your mail for verify the account.');
        return redirect()->back();
    }

    public function send_phone_verification_code()
    {
        $user = Auth::user();


        $user->phone_verification_code = rand(100000, 999999);
        $user->phone_verification_time = now()->addSeconds(env('OTP_EXPIRED_TIME',300))->toDateTimeString();
        $user->save();

        // Send verification email
        Mail::to($user->email)->send(new VerificationPhone($user));



        return response()->json(['success' => true]);
    }

    public function verify_phone_otp(Request $request)
    {
        $otp = $request->otp;

        $user = Auth::user();
        // dd($user, $verificationCode,$email);
        if ($user) {
            $phoneVerificationTime = strtotime($user->phone_verification_time);
            $currentTimestamp = time();

            $timeDifference = $currentTimestamp - $phoneVerificationTime;
            // dd($timeDifference);

            if ($timeDifference > 0) {
                return response()->json(['error' => 'Validation link expired']);
            }

            if ($user->phone_verification_code == $request->otp) {
                $user->is_phone_verified = 1;
                $user->save();
                return response()->json(['success' => true], 200);
            }
            return response()->json(['error' => 'Invalid OTP']);

        }
    }







    public function forgotPassword(){
        return view('demo_trade.forgotPassword');
    }
    public function forgotPasswordReset(Request $request){
        $user = PortalUser::where('email', '=', $request->email)->first();




        if ($user) {
            $user->email_verification_code = Hash::make(Str::random(6));
            $user->email_verification_time = now()->addSeconds(env('OTP_EXPIRED_TIME', 300))->toDateTimeString();
            $user->save();
            // dd($user);
        } else {

            return redirect()->back()->with('error','Email is not found');
        }

        // Send verification email
        Mail::to($user->email)->send(new PasswordResetMail($user));



        Session::flash('status', 'Please check your mail for verify the account.');
        return redirect()->back();

    }


    public function ResetPasswordVerify(Request $request){
        $verificationCode = $request->query('key');
        // dd($email, $verificationCode);

        $user = PortalUser::where('email_verification_code', $verificationCode)
            ->first();
        // dd($user, $verificationCode,$email);
        if ($user) {
            $emailVerificationTime = strtotime($user->email_verification_time);
            $currentTimestamp = time();

            $timeDifference = $currentTimestamp - $emailVerificationTime;
            // dd($timeDifference);

            if ($timeDifference > 0) {
                return redirect()->route('verify_timeout')->with('error', 'Validation link expired');
            }

            return view('demo_trade.SetNewPassword',compact('verificationCode'));
        }

        return redirect()->route('verify_invalid')->with('error', 'Invalid verification link.');
    }

    public function forgotPasswordResetSubmit(Request $request){


        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $key = $request->key;

        $user = PortalUser::where('email_verification_code', $key)->first();

        if(!$user){
            return redirect()->back()->with('error', 'invalid code');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('demotrading')->with('message', 'password changed');

    }





}
