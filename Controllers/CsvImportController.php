<?php

namespace App\Http\Controllers;

use Facade\FlareClient\View;
use Illuminate\Http\Request;
use App\Imports\EodImport;
use App\Imports\BlockTransactionImport;
use Maatwebsite\Excel\Facades\Excel;


class CsvImportController extends Controller
{
    public function eodupload(){
        return view('admin.csvupload.eod_form');
    }
    public function ImportEod( Request $request){
       
        if ($request->hasfile('file')) {
            $image = $request->file;
            $namewithextension = $image->getClientOriginalName(); //Name with extension 'filename.jpg'
            // $name = explode('.', $namewithextension)[0]; // Filename 'filename'
            // $extension = $image->getClientOriginalExtension(); //Extension 'jpg'
            // $uploadname = time() . '.' . $extension;
            // $image->move(public_path() . '/uploads/', $uploadname);

            
            Excel::import(new EodImport, $request->file('file'));

            return Redirect()->route('csvFileImport.eodupload')->with('message', 'Import Successfully done. File name '.$namewithextension);
        }
        else {
            return Redirect()->route('csvFileImport.eodupload')->with('error', 'Please select CSV File ');
        }
       
        
       
        //return "User Imported Successfully";
    }

    public function blockTrasactionupload(){
        return view('admin.csvupload.block_transaction_form');
    }
    public function ImportBlockTransaction( Request $request)
        {
            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $namewithextension = $image->getClientOriginalName(); // Name with extension 'filename.jpg'
    
                Excel::import(new BlockTransactionImport, $image);
    
                return redirect()->route('csvFileImport.blockTrasactionupload')->with('message', 'Import successfully done. File name: '.$namewithextension);
            } else {
                return redirect()->route('csvFileImport.blockTrasactionupload')->with('error', 'Please select a CSV file.');
            }
        //return "User Imported Successfully";
    }
}
