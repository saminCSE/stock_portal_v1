<?php

namespace App\Http\Controllers;

use App;
use App\Models\Book;
use App\Models\Review;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class HomeController extends Controller
{
    public function index() {
        $reviews = Review::where('is_approved', '=',1)->get();
        $user_manual = DB::table('settings')->value('user_manual');
        return view('home.index', compact('reviews','user_manual'));
    }
    public function QuickStart() {
        return view('page.QuickStart');
    }

    public function DefaultContent() {
        return view('page.DefaultContentPage');
    }
    public function PageNotFound() {
        return view('page.404');
    }
    public function ContactUs() {
        return view('page.ContactUs');
    }
    public function AboutUs() {
        return view('page.AboutUs');
    }
    public function MissionVision() {
        return view('page.mission_vision');
    }
    public function OurService() {
        return view('page.OurServices');
    }
    public function WeAreCommited() {
        return view('page.WeAreCommited');
    }
    public function AmlKyc() {
        return view('page.AmlKyc');
    }
    public function PrivacyPolicy() {
        return view('page.PrivacyPolicy');
    }
    public function PaymentPolicy() {
        return view('page.PaymentPolicy');
    }
    public function education(Request $request) {
        $key = "";
        if(isset($request->key)){
            $key = $request->key;
        }

        $books = Book::where('title', 'like', '%' . $key . '%')
                        ->paginate(10);
        return view('page.education',compact('books'));
    }

    public function payment_methods() {
        return view('page.payment_methods');
    }
}
