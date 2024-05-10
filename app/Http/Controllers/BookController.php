<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use App\Repositories\ImageUploadRepo;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
        return view('admin.book.book_list', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Create_book()
    {


        return view('admin.book.create_book');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        // validate the request

        $register = new Book();
        $register->title = $request->title;
        $register->description = $request->description;
        if ($request->hasFile('file')) {
            $pdf = $request->file;
            $path = public_path() . "/uploads/book/";
            $register->file = ImageUploadRepo::uploadPDF($path, $pdf,);
        }

        $register->save();
        return redirect('admin/book/create')->with('status', 'Book Create Successfully');
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
    public function edit_book($id)
    {
        $item = Book::find($id);
        return view('admin.book.create_book')->with(['item' => $item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_book(Request $request, $id)
    {


        $validatedData = $request->validate([
            'title' => 'required|max:255', // Example: Title is required and should not exceed 255 characters.
            'description' => 'required',
        ]);

        $register = Book::find($id);
        $register->title = $request->title;
        $register->description = $request->description;
        if ($request->hasFile('file')) {
            $pdf = $request->file;
            $path = public_path() . "/uploads/book/";
            $register->file = ImageUploadRepo::uploadPDF($path, $pdf,);
        }

        $register->update();
        return redirect('admin/book/list')->with('status', 'Book Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletebook($id){

        $book = Book::find($id);
        if(isset($book->file)){
            ImageUploadRepo::unlinkPath($book->file);
        }

        $book->delete();
        return redirect()->back();
    }

}
