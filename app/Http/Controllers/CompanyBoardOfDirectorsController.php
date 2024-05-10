<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyBoardOfDirectorsRequest;
use App\Models\Company;
use App\Models\CompanyBoardOfDirectors;
use App\Models\Designation;
use App\Models\DirectorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CompanyBoardOfDirectorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $companyBoardOfDirectors = DB::table('company_board_of_directors')
            ->join('company','company.id','=', 'company_board_of_directors.company_id')
            ->join('director_profiles','director_profiles.id','=', 'company_board_of_directors.directors_profiles_id')
            ->join('designations','designations.id','=', 'company_board_of_directors.designation_id')
            ->orderBy('company_board_of_directors.id','DESC')
            ->select('company.id','company.name AS company_name',
                'director_profiles.id','director_profiles.name AS director_name',
                'designations.id','designations.name AS designation_name',
                'company_board_of_directors.*')
            ->get();
//            ->toSql();
//        dd($companyBoardOfDirectors);
        return view('admin.company_board_of_director.index', compact('companyBoardOfDirectors'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::select('id','code','name')->where('isclose','=',1)
            ->orderBy('code','ASC')->get()->pluck('name', 'id')->prepend('Select Company', '');

        $directorProfile = DirectorProfile::select('id','name')
            ->orderBY('id','ASC')->get()->pluck('name','id')->prepend('Select Director', '');

        $designations = Designation::select('id','name')->where('designation_status', '=', 1)
            ->orderBY('id','ASC')->get()->pluck('name','id')->prepend('Select Designation', '');

        return view('admin.company_board_of_director.form',compact('designations','companies','directorProfile'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyBoardOfDirectorsRequest $request)
    {
        CompanyBoardOfDirectors::create($request->all());
        Session::flash('message', 'New Company Board Of Director Create Successfully');
        return redirect()->route('company_director.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompanyBoardOfDirectors  $companyBoardOfDirectors
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyBoardOfDirectors $companyBoardOfDirectors)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanyBoardOfDirectors  $companyBoardOfDirectors
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyBoardOfDirectors $company_director)
    {
        $companies = Company::select('id','code','name')->where('isclose','=',1)
            ->orderBy('code','ASC')->get()->pluck('name', 'id')->prepend('Select Company', '0');

        $directorProfile = DirectorProfile::select('id','name')
            ->orderBY('id','ASC')->get()->pluck('name','id')->prepend('Select Director', '0');

        $designations = Designation::select('id','name')->where('designation_status', '=', 1)
            ->orderBY('id','ASC')->get()->pluck('name','id')->prepend('Select Designation', '0');
        return view('admin.company_board_of_director.form')->with(['item'=>$company_director,
            'companies'=>$companies,'directorProfile'=>$directorProfile,'designations'=>$designations]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CompanyBoardOfDirectors  $companyBoardOfDirectors
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyBoardOfDirectorsRequest $request, CompanyBoardOfDirectors $company_director)
    {
        $company_director->update($request->all());
        Session::flash('message', 'New Company Board Of Director Update Successfully');
        return redirect()->route('company_director.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanyBoardOfDirectors  $companyBoardOfDirectors
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyBoardOfDirectors $company_director)
    {
        $company_director->delete();
        return redirect()->back()->with('status', 'Company Director Delete Successfully');
    }
}
