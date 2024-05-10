<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Instrument;
use App\Models\NewsPortal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsApiController extends Controller
{
    public function index(Request $request)
    {
        $limit = 20;
        $search_key = $request->get('searchKey');
        $from_date = $request->get('startDate');
        $to_date = $request->get('endDate');
        $selected_instruments = $request->get('selectedInstrument');
        $page = $request->page;

        $offset = ($page - 1) * $limit;

        $query = DB::table('news')
            ->select('id', 'prefix', 'details', 'post_date');
        //->where('details', 'like', "%{$search_key}%")

        // ->whereBetween('post_date', [$from_date, $to_date])

        if ($from_date && $to_date) {
            $query->whereRaw("DATE(`post_date`) >= '$from_date' and DATE(`post_date`) <= '$to_date'");
        }

        if ($search_key) {
            $query->where('details', 'like', "%{$search_key}%");
        }

        if (!empty($selected_instruments) && !in_array('0', $selected_instruments)) {
            $query->whereIn('instrument_id', $selected_instruments);
        }

        $news = $query->orderBy('id', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        $instruments = [];

        try {
            $response = array(
                'data' => array(
                    'news' => $news,
                ),
                'status' => 'success',
            );
            //dd($response);
            return response()->json($response);
        } catch (HttpException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
