<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\PortalUser;

class ForgetPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
    
        $user = PortalUser::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json(['errormessage' => 'User not found'], 404);
        }

        $token = Str::random(60);
        
        $expiresAt =Carbon::now()->addMinutes(expiredAt());

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'expired_time' => $expiresAt,
            'created_at' => Carbon::now()
        ]);
        $resetLink = config('siteconfig.frontend_url').'reset/password/token='.$token;

        Mail::send('admin.emails.password_reset', ['resetLink' => $resetLink], function ($message) use ($request, $resetLink) {
            $message->to($request->email);
            $message->subject('Reset Password');
            $message->setBody('<a href="'.$resetLink.'">Click here to reset your password</a>', 'text/html');
        });
        
        return response()->json(['message' => 'Password reset link sent to your email']);
    }  
    public function showResetForm(Request $request)
    {
        $token = $request->token;
        $resetData = DB::table('password_resets')->where('token', $token)->first();
        
        if (!$resetData) {
            return response()->json(['errormessage' => 'Token not found'], 404);
        }
        return response()->json([
            'token' => $token,
            'email' => $resetData->email,
        ]);
    } 

public function resetPassword(Request $request)
{
    $passwordReset = DB::table('password_resets')
        ->where('token', $request->token)
        ->first();

    if (!$passwordReset) {
        return response()->json(['errormessage' => 'Invalid or expired reset link'], 400);
    }

    if (Carbon::parse($passwordReset->expired_time)->isPast()) {
        
        return response()->json(['errormessage' => 'Reset link has expired'], 400);
    }

    $user = PortalUser::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['errormessage' => 'User not found'], 404);
    }
    $user->password = Hash::make($request->password);
    $user->save();
    DB::table('password_resets')
        ->where('token', $request->token)
        ->delete();

    return response()->json(['message' => 'Password reset successful']);
}
}
