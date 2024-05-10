<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $verificationLink = route('verification.verify', [
            'key' => $this->user->email_verification_code,
        ]);

        return $this->view('emails.verification')->with([
            'user' => $this->user,
            'verificationLink' => $verificationLink,
        ]);
    }
}
