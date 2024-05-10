<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ipo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Requests\IpoRequest;

class IpoController extends Controller
{
    public function Index(Request $request)
    {
        $fromDate = date('Y-m-d');
        $toDate   = date('Y-m-d');
        $page = 1;
        if ($request->isMethod('post')) {
            $fromDate = $request->from_date;
            $toDate = $request->to_date;
        }
        $ipo = DB::table('ipo')->whereRaw(
            "(date(Open_date) >= ? AND date(Open_date) <= ?)", 
            [
               $fromDate, 
               $toDate
            ]
            );

            $ipo = $ipo->orderBy('Open_date','DESC');
            $ipo = $ipo->paginate(pageLimit());

        return view('admin.ipo.ipo_list', compact('ipo','fromDate','toDate'));
    }
    public function CreateIpo()
    {
        $ipo = Ipo::all();
        $ipoboard = CommonController::IpoBoard();
        $asset_class = CommonController::Asset_Class();
        $methods = CommonController::Listing_Method();
        $ipo_status = CommonController::Ipo_Status();
        return view('admin.ipo.create_ipo', compact('ipoboard', 'asset_class','methods','ipo_status','ipo'));
    }



    public function Iporegister(IpoRequest $request)
    {
        $register = new Ipo();
        $register->name = $request->name;
        $register->board = $request->board;
        $register->asset_class = $request->asset_class;
        $register->methods = $request->methods;
        $register->status = $request->status;
        $register->Open_date = $request->Open_date;
        $register->close_date = $request->close_date;
        $register->ipo_size = $request->ipo_size;
        $register->offer_price = $request->offer_price;
        if($request->hasFile('summary')){
            $file = $request->file('summary');
            $filename=time().'.'.'Summary';
            $request->summary->move(public_path('/assets/files'),$filename);
            $register->summary=$filename;
           }          
        if($request->hasFile('prospectors')){
            $file = $request->file('prospectors');
            $filename=time().'.'.'Prospectors';
            $request->prospectors->move(public_path('/assets/files/'),$filename);
            $register->prospectors=$filename;
    }
        if($request->hasFile('results')){
            $file = $request->file('results');
            $filename=time().'.'.'Results';
            $request->results->move(public_path('/assets/files/'),$filename);
            $register->results=$filename;
          }
          $register->save();
        return redirect()->route('list.ipo')->with('status', 'New Ipo Create Successfully');
    }

    public function show($id)
    {
        $ipo=Ipo::find($id);
        $ipoboard = CommonController::IpoBoard();
        $asset_class = CommonController::Asset_Class();
        $methods = CommonController::Listing_Method();
        $ipo_status = CommonController::Ipo_Status();
       return view('admin.ipo.create_ipo')->with(['item'=>$ipo,'ipo_status'=>$ipo_status,'methods'=>$methods,'asset_class'=>$asset_class,'ipoboard'=>$ipoboard]);
    }
    public function update_Ipo(Request $request,$id)
     {
       $register=Ipo::find($id);
       $register->name = $request->name;
       $register->board = $request->board;
       $register->asset_class = $request->asset_class;
       $register->methods = $request->methods;
       $register->status = $request->status;
       $register->Open_date = $request->Open_date;
       $register->close_date = $request->close_date;
       $register->ipo_size = $request->ipo_size;
       $register->offer_price = $request->offer_price;

       if($request->hasFile('summary')){
        $summaryfile ='/public/assets/files/'.$register->summary;
        if(File::exists($summaryfile))
        {
            File::delete($summaryfile);
        }
            $file = $request->file('summary');
           $filename=time().'.'.$file->getClientOriginalName();
           $request->summary->move(public_path('/assets/files/'),$filename);
           $register->summary=$filename;
          }

          if($request->hasFile('prospectors')){
            $prospectorsfile ='/public/assets/files/'.$register->prospectors;
             if(File::exists($prospectorsfile))
             {  
                 File::delete($summaryfile);
             }
            $file = $request->file('prospectors');
            $filename=time().'.'.$file->getClientOriginalName();
            $request->prospectors->move(public_path('/assets/files/'),$filename);
            $register->prospectors=$filename;
             } 
             
           if($request->hasFile('results')){
            $resultsfile ='/public/assets/files/'.$request->results;
         if(File::exists($resultsfile))
         {
             File::delete($summaryfile);
         }
             $file = $request->file('results');
            $filename=time().'.'.$file->getClientOriginalName();
            $request->results->move(public_path('/assets/files/'),$filename);
            $register->results=$filename;
           }      
         $register->update();
         return redirect()->route('list.ipo')->with('status', 'Ipo Update Successfully');
    }
    public function DownloadSummary($id) {
        $datas= DB::table('ipo')->where('id',$id)->first();
        $file_path = public_path("/assets/files/{$datas->summary}");
        return response()->download($file_path);
      }
      public function DownloadProspectors($id) {
        $datas= DB::table('ipo')->where('id',$id)->first();
        $file_path = public_path("/assets/files/{$datas->prospectors}");
        return response()->download($file_path);
      }
      public function Downloadresults($id) {
        $datas= DB::table('ipo')->where('id',$id)->first();
        $file_path = public_path("/assets/files/{$datas->results}");
        return response()->download($file_path);
      }

    public function deleteIpo($id,Request $request)
    {
        $ipo=Ipo::find($id);
       if(unlink("assets/files/" . $ipo->summary) && unlink("assets/files/" . $ipo->prospectors) && unlink("assets/files/" . $ipo->results))
        $ipo->delete();
        return redirect()->back()->with('status', 'Ipo Delete Successfully.');
    }
}
