<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $contactMessage;

    public function __construct($name, $email, $contactMessage)
    {
        // $this->name=$data['name'];
        // $this->email=$data['email'];
        // $this->message=$data['message'];
        $this->name = $name;
        $this->email = $email;
        $this->contactMessage = $contactMessage;
    }

    public function build()
    {
        return $this->view('page.EmailBody')->subject('Contact Us Form Submission');;
    }
}
