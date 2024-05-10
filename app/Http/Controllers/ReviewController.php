<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Review::all();
        return view('admin.review.review_list', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Create_review()
    {


        return view('admin.review.create_review');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the request

        $validatedData = $request->validate([
            'user_name' => 'required|max:255', // Example: Title is required and should not exceed 255 characters.
            'star' => 'required',
            'review' => 'required|max:255',
        ]);

        $register = new review();
        $register->user_name = $request->user_name;
        $register->star = $request->star;
        $register->review = $request->review;
        $register->is_approved = 1;


        $register->save();
        return redirect('admin/review/create')->with('status', 'Review Create Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_review($id)
    {
        $item = review::find($id);
        return view('admin.review.create_review')->with(['item' => $item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_review(Request $request, $id)
    {


        $validatedData = $request->validate([
            'user_name' => 'required|max:255', // Example: Title is required and should not exceed 255 characters.
            'star' => 'required',
            'review' => 'required|max:255',
        ]);

        $register = Review::find($id);
        $register->user_name = $request->user_name;
        $register->star = $request->star;
        $register->review = $request->review;


        $register->update();
        return redirect('admin/review/list')->with('status', 'review Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletereview($id)
    {
        $review = Review::find($id);


        $review->delete();
        return redirect()->back();
    }
    public function approve($id)
    {
        $review = Review::find($id);

        $review->is_approved = 1;
        $review->save();
        return redirect()->back();
    }


    public function unapprove($id)
    {
        $review = Review::find($id);
        $review->is_approved = 0;
        $review->save();
        return redirect()->back();
    }

}
