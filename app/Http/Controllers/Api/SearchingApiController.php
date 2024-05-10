<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Company;
use App\Models\Instrument;
use App\Models\NewsPortal;
use HttpException;
use Illuminate\Http\Request;

class SearchingApiController extends Controller
{
    public function mainSearching(Request $request){

        $search_key = $request->get('q');
//dd($data);
        $symbols = Instrument::select('id','instrument_code','name')
            ->where('instrument_code', 'like', "%{$search_key}%")
            ->orWhere('name', 'like', "%{$search_key}%")
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        $company = Company::select('id','code','name')
            ->where('code', 'like', "%{$search_key}%")
            ->orWhere('name', 'like', "%{$search_key}%")
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        $news = NewsPortal::select('id','title','short_description','slug')
            ->where('title', 'like', "%{$search_key}%")
            ->orWhere('short_description', 'like', "%{$search_key}%")
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        $announcements = Announcement::select('id','prefix','details')
            ->where('prefix', 'like', "%{$search_key}%")
            ->orWhere('details', 'like', "%{$search_key}%")
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();


        try {
            $response = array(
                'data'=>array(
                    'symbols'       =>$symbols,
                    'company'       =>$company,
                    'news'          =>$news,
                    'announcements' =>$announcements,
                ),
                'status'=>'success',
            );
            return response()->json($response);
        } catch (HttpException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
