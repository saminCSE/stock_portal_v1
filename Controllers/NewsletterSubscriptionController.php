<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscription;

class NewsletterSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newsletter= NewsletterSubscription::all(); return view('admin.news_letter.index',compact('newsletter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(NewsletterSubscription $newsletter)
    {
        $activestatus = CommonController::yesno();
        $promotionstatus = CommonController::IsPromotion();
        return view('admin.news_letter.form')->with(['activestatus' => $activestatus, 'promotionstatus' => $promotionstatus, 'item' => $newsletter]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $register = NewsletterSubscription::find($id);
        $register->is_promotion = $request->is_promotion;
        $register->is_active = $request->is_active;
        $register->update();
        return redirect('admin/newsletter')->with('status', 'News letter Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $newsletter =NewsletterSubscription::find($id);
        $newsletter->delete();
        return redirect()->back()->with('status', 'News Letter Delete Successfully.');
    }
}
