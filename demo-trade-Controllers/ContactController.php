<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactEmail;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function showContactForm()
    {
        return view('page.ContactUs');
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'contactMessage' => 'required',
        ]);
        $data=$request->all();
        $formdata = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'contactMessage' => $request->input('contactMessage'),
        ];
        
        try {
            DB::table('contact_us_mail')->insert($formdata);
            Mail::to('sa579780@gmail.com')->send(new ContactEmail($data['name'], $data['email'], $data['contactMessage']));
            return redirect()->back()->with('Emailsuccess', 'Email sent successfully!');
        } catch (\Exception $e) {
            // Handle the exception
            return redirect()->back()->with('Emailsuccess', 'An error occurred while sending the email.');
        }
    }
}
