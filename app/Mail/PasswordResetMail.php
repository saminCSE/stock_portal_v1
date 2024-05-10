<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $resetLink = route('resetpassword.verify', [
            'key' => $this->user->email_verification_code,
        ]);

        return $this->view('emails.resetpassword')->with([
            'user' => $this->user,
            'resetLink' => $resetLink,
        ]);
    }
}
