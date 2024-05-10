<?php

namespace App\Http\Controllers;

use App\Http\Requests\DirectorProfileRequest;
use App\Models\Designation;
use App\Models\DirectorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DirectorProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
//           ->select('users.*', 'contacts.phone', 'orders.price')
    {
        $directorProfiles = DB::table('designations' )
            ->join('director_profiles','designations.id','director_profiles.designation_id')
            ->where('designations.designation_status', 1)
            ->orderBy('director_profiles.id','desc')
            ->select('designations.id','designations.name AS designation_name','director_profiles.*')
            ->get();
        return view('admin.director_profile.index', compact('directorProfiles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $designations = Designation::select('id','name')->where('designation_status', '=', 1)
            ->orderBY('id','ASC')->get()->pluck('name','id')->prepend('Select Designation', '0');
        return view('admin.director_profile.form',compact('designations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DirectorProfileRequest $request)
    {
        DirectorProfile::create($request->all());
        Session::flash('message', 'New Director Profile Create Successfully');
        return redirect()->route('director_profile.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\directorProfile  $directorProfile
     * @return \Illuminate\Http\Response
     */
    public function show(directorProfile $directorProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\directorProfile  $directorProfile
     * @return \Illuminate\Http\Response
     */
    public function edit(DirectorProfile $directorProfile )
    {
        $designations = Designation::select('id','name')->where('designation_status', '=', 1)
            ->orderBY('id','ASC')->get()->pluck('name','id')->prepend('Select Designation', '0');
        return view('admin.director_profile.form',with(['item'=>$directorProfile,'designations'=>$designations]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\directorProfile  $directorProfile
     * @return \Illuminate\Http\Response
     */
    public function update(DirectorProfileRequest $request, DirectorProfile $directorProfile)
    {
        $directorProfile->update($request->all());
        return redirect()->route('director_profile.index')->with('status', 'Director Profile Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\directorProfile  $directorProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(directorProfile $directorProfile)
    {
        $directorProfile->delete();
        return redirect()->back()->with('status', 'Director Delete Successfully');
    }
}
