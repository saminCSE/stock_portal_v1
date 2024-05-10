<?php

namespace App\Http\Controllers;

// use auth;
use App\Models\Instrument;
use Illuminate\Support\Str;
use App\Models\ContestOrder;
use Illuminate\Http\Request;
use App\Models\ContestLedger;
use App\Mail\VerificationMail;
use App\Models\PortfolioTrend;
use Illuminate\Support\Carbon;
use App\Mail\VerificationPhone;
use App\Models\ContestPortfolio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CreatePortfolioRequest;

class FreeDemoController extends Controller
{
    public function index()
    {
        $settings = DB::table('settings')->first();
        $contestUserTypes = DB::table('contest_user_types')
            ->orderBy('title', 'asc')
            ->pluck('title', 'id');


        // $contests = DB::table('contests')
        //     ->where('contest_end_date', '>', date('Y-m-d'))
        //     ->orderBy('title', 'desc')
        //     ->get();

        $is_enrolled = null;
        if (Auth::user()) {
            $is_enrolled = DB::table('contest_profiles')
                ->leftJoin('contests', 'contests.id', 'contest_profiles.contests_id')
                ->where('contests.slug', env('Free_demo_slug', 'free-demo'))
                ->where('portal_user_id', Auth::user()->id)
                ->first();
        }
        // dd($is_enrolled);

        $comission = DB::table('commissions')
            ->where('title', '=', 'Commission')
            ->orderBy('created_at', 'desc')
            ->value('value');

        $deposit_amount = DB::table('contests')
            ->where('slug', env('Free_demo_slug', 'free-demo'))
            ->value('amount');




        $video = DB::table('contest_videos')->where('contests_id', 0)->first();

        $common_tac = DB::table('settings')->first()->term_and_condition;
        $common_tac_bn = DB::table('settings')->first()->term_and_condition_bn;


        return view('demo_trade.index', compact('contestUserTypes', 'video', 'common_tac', 'common_tac_bn', 'is_enrolled', 'comission', 'deposit_amount', 'settings'));
    }
    public function demoContest()
    {
        $contestUserTypes = DB::table('contest_user_types')
            ->orderBy('title', 'asc')
            ->pluck('title', 'id');


        $contests = DB::table('contests')
            ->where('slug', '!=', env('Free_demo_slug', 'free-demo'))
            ->where('contest_end_date', '>', date('Y-m-d'))
            ->orderBy('title', 'desc')
            ->get();
        // dd($contests);




        $video = DB::table('contest_videos')->where('contests_id', 0)->first();

        $common_tac = DB::table('settings')->first()->term_and_condition;
        $common_tac_bn = DB::table('settings')->first()->term_and_condition_bn;
        $settings = DB::table('settings')->first();


        return view('demo_trade.demo_contest', compact('contestUserTypes', 'contests', 'video', 'common_tac', 'common_tac_bn', 'settings'));
    }

    public function ContestDetails($slug)
    {
        $contest = DB::table('contests')->where('slug', $slug)->first();
        $id = $contest->id;
        $contests_id = $id;

        $contest = DB::table('contests')->where('id', $id)->first();
        $video = DB::table('contest_videos')->where('contests_id', $id)->first();

        $prizes = DB::table('prizes')->where('contest_id', $id)
            ->orderBy('rank', 'asc')
            ->get();
        $contestUserTypes = DB::table('contest_user_types')
            ->orderBy('title', 'asc')
            ->pluck('title', 'id');

        $common_tac = DB::table('settings')->first()->term_and_condition;
        $common_tac_bn = DB::table('settings')->first()->term_and_condition_bn;
        $settings = DB::table('settings')->first();
        // $contestLeaderboard = DB::table('contest_portfolios')
        //     ->where('contests_id', $contests_id)
        //     // ->select("*")
        //     ->selectRaw('(saleable_quantity + pending_holding_quantity) * market_price AS single_instrument_current_value')
        //     ->selectRaw("sum(single_instrument_current_value) as sum_value")
        // //    ->groupBy('portal_user_id')
        //     ->get();


        $contestLeaderboard = DB::table('contest_portfolios')
            ->where('contests_id', $contests_id)
            ->selectRaw('(saleable_quantity + pending_holding_quantity) * market_price AS single_instrument_current_value')
            ->get();

        $totalCurrentValueForAlluser = $contestLeaderboard->sum('single_instrument_current_value');



        // $contestLeaderboardTopTenUsers = DB::table('contest_portfolios')
        //     ->join('portal_user', 'contest_portfolios.portal_user_id', '=', 'portal_user.id')
        //     ->select('portal_user_id', 'portal_user.full_name')
        //     ->selectRaw('SUM(saleable_quantity + pending_holding_quantity) * MAX(market_price) AS totalCurrentValueForSingleUser')
        //     ->where('contest_portfolios.contests_id', $contests_id)
        //     ->groupBy('portal_user_id', 'portal_user.full_name')
        //     ->orderByDesc('totalCurrentValueForSingleUser')
        //     ->limit(10)
        //     ->get();

        $contestLeaderboardTopTenUsers = DB::table('contest_portfolios')
            ->join('portal_user', 'contest_portfolios.portal_user_id', '=', 'portal_user.id')
            ->leftJoin('contest_orders', function ($join) use ($contests_id) {
                $join->on('contest_portfolios.portal_user_id', '=', 'contest_orders.portal_user_id')
                    ->where('contest_orders.contests_id', '=', $contests_id);
            })
            ->leftJoin('contest_profiles', function ($join) use ($contests_id) {
                $join->on('contest_profiles.portal_user_id', '=', 'portal_user.id')
                    ->where('contest_profiles.contests_id', '=', $contests_id);
            })
            ->select('contest_portfolios.portal_user_id', 'portal_user.full_name')
            ->selectRaw('SUM(saleable_quantity + pending_holding_quantity) * MAX(market_price) AS totalCurrentValueForSingleUser')
            ->selectRaw('SUM(contest_orders.value) AS transaction_value')
            ->selectRaw('MAX(contest_profiles.rank_position) AS user_rank')
            ->where('contest_portfolios.contests_id', $contests_id)
            ->groupBy('contest_portfolios.portal_user_id', 'portal_user.full_name')
            ->orderBy('user_rank')
            ->limit(10)
            ->get();






        // dd($contestLeaderboardTopTenUsers);


        $isenrolled = null;
        if (Auth::user()) {
            $user_id = Auth::user()->id;
            $isenrolled = DB::table('user_contests')->where('portal_user_id', $user_id)->where('contest_id', $id)->first();
        }


        // dd($contest);
        // dd($video);
        return view('demo_trade.contest_details', compact('contest', 'contestUserTypes', 'prizes', 'video', 'isenrolled', 'contestLeaderboardTopTenUsers', 'common_tac', 'common_tac_bn', 'settings'));
    }


    public function DemoSignup(Request $request)
    {
        $customMessages = [
            'name.required' => 'Please enter your name',
            'email.required' => 'Please enter your email address',
            'email.email' => 'Please enter a valid email address',
            'mobile.required' => 'Please enter your phone number',
            'mobile.numeric' => 'Please enter a valid phone number',
            'mobile.digits' => 'Phone number must be 11 digits',
            'gender.required' => 'Please select your gender',
            'contest_user_type_id.required' => 'Please select a user type',
            'password.required' => 'Please enter a password',
            'password.min' => 'Password must be at least 8 characters',
            'password_confirmation.required' => 'Please confirm your password',
            'password_confirmation.same' => 'Passwords do not match',
            'agreeTerms.required' => 'You must agree to the terms and conditions',
            // 'g-recaptcha-response.required' => 'Please complete the captcha.',
            // 'g-recaptcha-response.recaptcha' => 'Captcha verification failed.',
        ];
        $customRules = [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric|digits:11',
            'gender' => 'required',
            'contest_user_type_id' => 'required',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'agreeTerms' => 'required',
            // 'g-recaptcha-response' => 'required|recaptcha',
        ];

        $validator = Validator::make($request->all(), $customRules, $customMessages);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->with(['from' => 'regform'])
                ->withInput();
        }

        $data = $request->all();
        $user_id = DB::table('portal_user')->insertGetId([
            'full_name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'gender' => $data['gender'],
            'organization' => $data['organization'],
            'contest_user_type_id' => $data['contest_user_type_id'],
            'nid' => $data['nid'],
            'password' => Hash::make($data['password']),
            'email_verification_code' => Hash::make(Str::random(6)),
            'email_verification_time' => now()->toDateTimeString(),
        ]);

        if ($user_id) {
            $user = DB::table('portal_user')->find($user_id);

            // Send verification email
            // Mail::to($user->email)->send(new VerificationMail($user));
        }



        Session::flash('message', 'Dear ' . $request->name . ', Thank you for your registration, Please check your mail for verify the account.');
        return redirect()->route('demotrading');
    }



    public function DemoLogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            // 'g-recaptcha-response' => 'required|recaptcha',
        ], [
            'g-recaptcha-response.recaptcha' => 'Captcha verification failed',
            'g-recaptcha-response.required' => 'Please complete the captcha',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'The password field is required.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->only('email'))
                ->with(['from' => 'loginform']); // Keep the email input value
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {

            $tokenid = (string) Str::uuid();
            $user = Auth::user();
            $token_sha256 = hash('sha256', $tokenid);
            $user->update([
                'api_token' => $token_sha256,
            ]);
            //Cookie::queue(Cookie::forget('name'));
            $domain = env('SESSION_DOMAIN', null);
            $crypt_token = Crypt::encrypt($token_sha256);
            Cookie::queue('sheba-auth-token', $crypt_token, 3780, '/', $domain, false, false);

            // return redirect()->route('demo.user_dashboard');
            return redirect()->back();
        }

        return redirect()
            ->back()
            ->withInput($request->only('email'))
            ->withErrors(['error' => 'Invalid email or password.'])
            ->with(['from' => 'loginform']);
    }



    public function DemoLogout()
    {
        Auth::logout();
        Cookie::queue(Cookie::forget('sheba-auth-token'));
        return redirect()->back();
    }






    public function UserDashboard()
    {
        $portal_user_id = auth()->id();

        // Get the contests that the user is not enrolled in
        $contests = DB::table('contests')
            ->where('slug', '!=', env('Free_demo_slug', 'free-demo'))
            ->leftJoin('user_contests', function ($join) use ($portal_user_id) {
                $join->on('contests.id', '=', 'user_contests.contest_id')
                    ->where('user_contests.portal_user_id', '=', $portal_user_id);
            })
            ->select('contests.*', 'user_contests.id as user_contest_id', 'user_contests.portal_user_id', 'user_contests.contest_id')
            ->whereNull('user_contests.contest_id')
            ->orderBy('contests.contest_start_date', 'asc')
            ->get();

        // Get the contests that the user is  enrolled in
        $contestsEnrolledIn = DB::table('contests')
            ->where('slug', '!=', env('Free_demo_slug', 'free-demo'))
            ->join('user_contests', function ($join) use ($portal_user_id) {
                $join->on('contests.id', '=', 'user_contests.contest_id')
                    ->where('user_contests.portal_user_id', '=', $portal_user_id);
            })
            ->leftJoin('contest_profiles', function ($join) use ($portal_user_id) {
                $join->on('contests.id', '=', 'contest_profiles.contests_id')
                    ->where('contest_profiles.portal_user_id', '=', $portal_user_id); // Specify the table
            })
            ->orderBy('contests.contest_end_date', 'asc')
            ->get();

        // dd($contestsEnrolledIn);
        return view('demo_trade.user_panel', compact('contests', 'contestsEnrolledIn'));
    }


    public function UserEnroll($slug, Request $request)
    {

        if ($slug == env('Free_demo_slug', 'free-demo')) {
            // Manual validation
            $validator = Validator::make($request->all(), [
                'brokerHouse' => 'required',
                'branchName' => 'required',
                'portfolioName' => 'required',
                'commissionRate' => ['required', 'numeric', 'between:0,100'],
                'depositAmount' => 'required|numeric',
            ], [
                'brokerHouse.required' => 'Please enter the Broker House Name',
                'branchName.required' => 'Please enter the Branch Name',
                'portfolioName.required' => 'Please enter the Portfolio Name',
                'commissionRate.required' => 'Please enter the Commission Rate',
                'commissionRate.numeric' => 'Please enter a valid number for Commission Rate',
                'commissionRate.between' => 'Please enter a number between 0 and 100 for Commission Rate',
                'depositAmount.required' => 'Please enter the Deposit Amount',
                'depositAmount.numeric' => 'Please enter a valid number for Deposit Amount',
            ]);

            if ($validator->fails()) {
                session::flash('portfolioerror', true);
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::table('free_demo_broker')->insert([
                'broker_house_name' => $request->input('brokerHouse'),
                'branch_name' => $request->input('branchName'),
                'portfolio_name' => $request->input('portfolioName'),
                'user_id' => auth()->user()->id,
                'deposite_amount' => $request->input('depositAmount'),
                'commision_rate' => $request->input('commissionRate'),
            ]);
        }



        $contest = DB::table('contests')->where('slug', $slug)->first();
        $id = $contest->id;
        $portal_user_id = auth()->id();
        $contest_id = $id;
        $join_date = Carbon::now()->toDateString();

        $contest = DB::table('contests')->where('id', $id)->first();
        $deposit_amount = $contest->amount;

        $alreadyenrolled = DB::table('user_contests')->where('portal_user_id', $portal_user_id)->where('contest_id', $contest_id)->first();
        if ($alreadyenrolled) {
            return redirect()->route('demo.user_dashboard')->with('message', 'Already Enrolled');
        }

        // dd( $contest_id);
        // dd( $portal_user_id);
        // dd( $join_date);
        // dd( $deposit_amount);

        DB::table('user_contests')->insert([
            'portal_user_id' => $portal_user_id,
            'contest_id' => $contest_id,
            'join_date' => $join_date,
        ]);

        if ($contest->slug == env('Free_demo_slug', 'free-demo')) {
            DB::table('contest_profiles')->insert([
                'portal_user_id' => $portal_user_id,
                'contests_id' => $contest_id,
                'deposit_amount' => $request->input('depositAmount'),
                'balance' => $request->input('depositAmount'),
            ]);

            $account_ledger = array(
                'contests_id' => $contest_id,
                'portal_user_id' => $portal_user_id,
                'instrument_code' => 0,
                'remark' => 'initial deposit',
                'quantity' => 0,
                'price' => 0,
                'credit' => $request->input('depositAmount'),
                'debit' => 0,
                'commission' => 0,
                'balance' => $request->input('depositAmount'),
                'purchase_date' => now(),
                'purchase_time' => now()
            );
        } else {
            DB::table('contest_profiles')->insert([
                'portal_user_id' => $portal_user_id,
                'contests_id' => $contest_id,
                'deposit_amount' => $deposit_amount,
                'balance' => $deposit_amount,
            ]);

            $account_ledger = array(
                'contests_id' => $contest_id,
                'portal_user_id' => $portal_user_id,
                'instrument_code' => 0,
                'remark' => 'initial deposit',
                'quantity' => 0,
                'price' => 0,
                'credit' => $deposit_amount,
                'debit' => 0,
                'commission' => 0,
                'balance' => $deposit_amount,
                'purchase_date' => now(),
                'purchase_time' => now()
            );
        }



        // dd($account_ledger);

        $profile_ledger = ContestLedger::create($account_ledger);

        return redirect()->route('demo.contest.panel', ['slug' => $slug])->with('message', 'Contest Enroll Successfully');
    }

    public function ContestPanel($slug)
    {

        $contest = DB::table('contests')->where('slug', $slug)->first();
        $id = $contest->id;

        $portal_user_id = auth()->id();
        $contests_id = $id;

        $is_today_open = DB::table('market_schedulers')->where('open_date', now()->format('Y-m-d'))->first();
        date_default_timezone_set('Asia/Dhaka');
        $is_now_open = DB::table('market_schedule_settings')
            ->where('open_time', '<=', now()->format('H:i:s'))
            ->where('close_time', '>=', now()->format('H:i:s'))
            ->first();
        // dd($is_now_open);
        $is_open = 0;
        if ($is_today_open && $is_now_open) {
            $is_open = 1;
        }



        $schedule = DB::table("market_schedule_settings")->first();
        $contest = DB::table('contests')->where('id', $id)->first();

        $broker_details = null;
        if ($contest->slug == env('Free_demo_slug', 'free-demo')) {
            $broker_details = DB::table('free_demo_broker')->where('user_id', $portal_user_id)->first();
        }
        // dd($broker_details);

        $transactionHistoryes = DB::table('contest_orders')
            ->where('portal_user_id', $portal_user_id)
            ->where('contests_id', $contests_id)
            ->select('id', 'instrument_code', 'quantity', 'price', 'value', 'side', 'purchase_date', 'purchase_time')
            ->orderBy('purchase_date', 'desc')
            // ->paginate(10);
            ->get();



        $contest_portfolios = DB::table('contest_portfolios')
            ->where('portal_user_id', $portal_user_id)
            ->where('contests_id', $contests_id)
            ->whereRaw('saleable_quantity + pending_holding_quantity > 0') // Use whereRaw for mathematical operations
            ->orderBy('instrument_code', 'asc')
            // ->paginate(10);
            ->get();

        $totalPortfolioValue = $contest_portfolios->sum('market_price');

        // dd($contest_portfolios);

        $contest_profiles = DB::table('contest_profiles')
            ->where('portal_user_id', $portal_user_id)
            ->where('contests_id', $contests_id)
            ->select('balance', 'deposit_amount')
            ->first();

        $contestUserTypes = DB::table('contest_user_types')
            ->orderBy('title', 'asc')
            ->pluck('title', 'id')
            ->prepend('Select Contest User Type', '');

        // ========================================================================== Need To Re-Calculate All Data ===================================================================

        $totalReturnData = DB::table('contest_portfolios')
            ->select("*")
            ->where('portal_user_id', $portal_user_id)
            ->where('contests_id', $contests_id)
            ->selectRaw('(saleable_quantity + pending_holding_quantity) * market_price AS single_instrument_current_value,
                         (saleable_quantity + pending_holding_quantity) * market_price - total_cost_value AS single_instrument_total_return,
                         (total_gain - total_loss) AS neat_gain')

            ->get();
        // dd($totalReturnData);

        // How to handle negative value return like -1500

        $totalCurrentValue = $totalReturnData->sum('single_instrument_current_value');
        $totalTotalReturn = $totalReturnData->sum('single_instrument_total_return');
        $neat_gain = $totalReturnData->sum('neat_gain');


        $totalReturn = $totalCurrentValue - $totalTotalReturn;
        // $totalReturn = (($totalCurrentValue - $totalTotalReturn) / $totalTotalReturn) * 100;

        // $totalReturn = 0;
        // if ($totalTotalReturn > $totalCurrentValue) {
        //     $totalReturn = (($totalTotalReturn - $totalCurrentValue) / $totalCurrentValue) * 100;
        // } elseif ($totalTotalReturn < $totalCurrentValue) {
        //     $totalReturn = - ((($totalCurrentValue - $totalTotalReturn) / $totalTotalReturn) * 100);
        // } else {
        //     $totalReturn = 0;
        // }

        // dd($totalReturn);



        // dd($topTenUsers);

        // ========================================================================== Need To Re-Calculate All Data ===================================================================


        $breakdown = ContestPortfolio::where('portal_user_id', $portal_user_id)
            ->where('contests_id', $contests_id)
            ->leftJoin('instruments', 'instruments.instrument_code', 'contest_portfolios.instrument_code')
            ->leftJoin('sector', 'instruments.sector_list_id', 'sector.id')
            ->select('sector.name as sector_name')
            ->selectRaw('SUM((contest_portfolios.saleable_quantity + contest_portfolios.pending_holding_quantity) * contest_portfolios.market_price) AS total_current_value')
            ->whereNotNull('sector.name')
            ->groupBy('sector_name')
            ->havingRaw('SUM((contest_portfolios.saleable_quantity + contest_portfolios.pending_holding_quantity)) > 0')
            ->get()
            ->toArray();


        // dd($breakdown);
        $sectorNames = array_column($breakdown, 'sector_name');
        $totalCurrentValues = array_column($breakdown, 'total_current_value');

        // Create the desired output array
        $breakdown = [
            ['sector_names' => $sectorNames],
            ['total_current_value' => $totalCurrentValues],
        ];
        // dd($breakdown);

        $portfolioTrends = PortfolioTrend::where('contests_id', $contests_id)
            ->where('portal_user_id', $portal_user_id)
            ->orderBy('trend_date', 'ASC')
            ->get()
            ->toArray();

        $user_ids = array_column($portfolioTrends, 'portal_user_id');
        $cashes = array_column($portfolioTrends, 'Cash');
        $marketvalues = array_column($portfolioTrends, 'market_value');
        $portfolio_values = array_column($portfolioTrends, 'portfolio_value');
        $dates = array_column($portfolioTrends, 'trend_date');

        $portfolioTrends = [
            ['user_ids' => $user_ids],
            ['cashes' => $cashes],
            ['marketvalues' => $marketvalues],
            ['portfolio_values' => $portfolio_values],
            ['dates' => $dates],
        ];
        // dd($portfolioTrends);

        return view('demo_trade.contest_panel', compact('contest', 'contestUserTypes', 'contest_portfolios', 'contest_profiles', 'totalPortfolioValue', 'totalTotalReturn', 'totalCurrentValue', 'transactionHistoryes', 'totalReturn', 'schedule', 'neat_gain', 'breakdown', 'portfolioTrends', 'is_open', 'broker_details'));
    }

    public function get_transactionHistory(Request $request, $id)
    {

        try {
            $portal_user_id = auth()->user()->id;


            // DB::enableQueryLog();
            $transactionHistoryes = DB::table('contest_orders')
                ->where('portal_user_id', $portal_user_id)
                ->where('contests_id', $id)
                ->select('id', 'instrument_code', 'quantity', 'price', 'value', 'side', 'purchase_date', 'purchase_time')
                ->orderBy('purchase_date', 'desc')
                ->paginate(10);

            // dd($transactionHistoryes);



            // dd($contest_portfolios);
            return response()->json([
                'success' => true,
                'data' => $transactionHistoryes,
                'message' => 'data retrieved successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving demo data: ' . $e->getMessage(),
            ], 500);
        }
    }




    public function get_contest_portfolios(Request $request, $id)
    {

        try {
            $portal_user_id = auth()->user()->id;

            // DB::enableQueryLog();
            $contest_portfolios = DB::table('contest_portfolios')
                // ->where('portal_user_id', $portal_user_id)
                ->where('contests_id', $id)
                ->orderBy('instrument_code', 'asc')
                ->paginate(10);

            $totalReturnData = DB::table('contest_portfolios')
                ->select("*")
                ->where('portal_user_id', $portal_user_id)
                ->where('contests_id', $id)
                ->selectRaw('(saleable_quantity + pending_holding_quantity) * market_price AS single_instrument_current_value,
                         (saleable_quantity + pending_holding_quantity) * market_price - total_cost_value AS single_instrument_total_return')
                ->get();
            $totalTotalReturn = $totalReturnData->sum('single_instrument_total_return');

            // dd($contest_portfolios);
            return response()->json([
                'success' => true,
                'data' => $contest_portfolios,
                'totalReturn' => $totalTotalReturn,
                'message' => 'data retrieved successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving demo data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function MakeTrade($slug)
    {

        $is_today_open = DB::table('market_schedulers')->where('open_date', now()->format('Y-m-d'))->first();
        date_default_timezone_set('Asia/Dhaka');
        $is_now_open = DB::table('market_schedule_settings')
            ->where('open_time', '<=', now()->format('H:i:s'))
            ->where('close_time', '>=', now()->format('H:i:s'))
            ->first();
        // dd($is_now_open);




        $contest = DB::table('contests')->where('slug', $slug)->first();
        $id = $contest->id;
        $portal_user_id = auth()->id();

        $contest = DB::table('contests')->where('id', $id)->first();


        $contest = DB::table('contests')->where('id', $id)->first();

        $broker_details = null;
        if ($contest->slug == env('Free_demo_slug', 'free-demo')) {
            $broker_details = DB::table('free_demo_broker')->where('user_id', $portal_user_id)->first();
        }


        $companies = DB::table('instruments')
            ->orderBy('instrument_code', 'asc')
            ->leftJoin('sector', 'instruments.sector_list_id', '=', 'sector.id')
            ->rightJoin('company_basic_information', 'instruments.instrument_code', '=', 'company_basic_information.code')
            ->whereNotNull('company_basic_information.market_price') // Use whereNotNull instead of whereNot
            ->select('instruments.*', 'sector.name as sector_name')
            ->get();


        $contests_id = $id;

        $contest_profiles = DB::table('contest_profiles')
            ->where('portal_user_id', $portal_user_id)
            ->where('contests_id', $contests_id)
            ->select('balance', 'deposit_amount')
            ->first();

        $saleableSymbols = DB::table('contest_portfolios')
            ->where('portal_user_id', $portal_user_id)
            ->where('contests_id', $contests_id)
            ->where('saleable_quantity', '<>', 0)
            ->leftJoin('instruments', 'instruments.instrument_code', 'contest_portfolios.instrument_code')
            ->leftJoin('sector', 'sector.id', 'instruments.sector_list_id')
            ->select('contest_portfolios.*', 'instruments.instrument_code', 'instruments.name', 'sector.name as sector_name')
            ->orderBy('contest_portfolios.instrument_code', 'asc')
            ->get();

        if ($contest->slug == env('Free_demo_slug', 'free-demo')) {
            $brokerage_fee = DB::table('free_demo_broker')
                ->where('user_id', '=', $portal_user_id)
                ->value('commision_rate');
        } else {
            $brokerage_fee = DB::table('commissions')
                ->where('title', '=', 'Commission')
                ->orderBy('created_at', 'desc')
                ->select('value')
                ->first()->value;
        }




        // dd($brokerage_fee);
        return view('demo_trade.make_trade', compact('companies', 'saleableSymbols', 'contest', 'contest_profiles', 'brokerage_fee', 'broker_details'));
    }

    public function getLastTradePrice(Request $request)
    {

        $selectedStock = $request->input('stock');
        $contests_id = $request->input('contests_id');
        $portal_user_id = auth()->id();

        $lastTradePrice = DB::table('company_basic_information')
            ->where('code', $selectedStock)
            ->value('market_price');

        $lastBalance = DB::table('contest_profiles')
            ->where('portal_user_id', $portal_user_id)
            ->where('contests_id', $contests_id)
            ->value('balance');

        $saleable_quantity = null;

        $saleable_quantity = DB::table('contest_portfolios')
            ->where('portal_user_id', $portal_user_id)
            ->where('contests_id', $contests_id)
            ->where('instrument_code', $selectedStock)
            ->value('saleable_quantity');


        // $saleable_quantity = DB::table('contest_portfolios')
        //     ->where('portal_user_id', $portal_user_id)
        //     ->where('contests_id', $contests_id)
        //     ->where('instrument_code', $selectedStock);

        // $saleable_quantity = $saleable_quantity->toSql();

        // dd($saleable_quantity);




        return response()->json(['lastTradePrice' => $lastTradePrice, 'lastBalance' => $lastBalance, 'saleable_quantity' => $saleable_quantity]);
    }

    public function BuyOrderCheck()
    {
    }

    public function SellOrderCheck()
    {
    }


    public function MakeTradeBuy(Request $request)
    {
        $contests_id = $request->input('contests_id');
        $portal_user_id = auth()->id();

        $contest_profiles = DB::table('contest_profiles')
            ->where('portal_user_id', $portal_user_id)
            ->where('contests_id', $contests_id)
            ->select('balance', 'deposit_amount')
            ->first();

        $validatedData = $request->validate([
            'instrument_code' => 'required',
            'quantity' => 'required|integer|min:1',
        ], [
            'instrument_code.required' => 'Please select an instrument code.',
            'quantity.required' => 'Please enter the quantity.',
            'quantity.integer' => 'Quantity must be an integer.',
            'quantity.min' => 'Quantity must be at least :min.',
        ]);

        if ($validatedData['quantity'] * $request->price > $contest_profiles->balance) {
            return redirect()->back()->with('buyerror', 'Insufficient balance');
        }

        $instrument = Instrument::select('id', 'instrument_code', 'isin')->where('instrument_code', $request->instrument_code)->first();

        $contest = DB::table('contests')->where('id', $contests_id)->first();
        if ($contest->slug == env('Free_demo_slug', 'free-demo')) {
            $total_commision = floatval(DB::table('free_demo_broker')->where('user_id', '=', $portal_user_id)->value('commision_rate')) * floatval(DB::table('company_basic_information')->where('code', $request->instrument_code)->first()->market_price) * $request->quantity / 100;

        } else {
            $total_commision = floatval(DB::table('commissions')->first()->value) * floatval(DB::table('company_basic_information')->where('code', $request->instrument_code)->first()->market_price) * $request->quantity / 100;
        }




        $total_price = floatval(DB::table('company_basic_information')->where('code', $request->instrument_code)->first()->market_price) * $request->quantity;


        $data = $request->all();
        $data['side'] = 'B';
        $data['total_commision'] = $total_commision;
        $data['portal_user_id'] = $portal_user_id;
        $data['contests_id'] = $contests_id;
        $data['instrument_code'] = $request->instrument_code;
        $data['value'] = $total_price;
        $data['status'] = 'Fill';
        $data['isin'] = $instrument->isin;
        $data['board'] = 'PUBLIC';
        $data['fill_type'] = 'FILL';
        $data['category'] = 'A';
        $data['purchase_date'] = now()->toDateString(); // Use Carbon for consistent date formatting
        $data['purchase_time'] = now()->toTimeString(); // Use Carbon for consistent time formatting

        $status = ContestOrder::productorderprocess($data);

        return redirect()->route('demo.contest.panel', $contest->slug)->with('message', 'Buy order successful');
    }



    public function MakeTradeSell(Request $request)
    {
        $contests_id = $request->contests_id;
        $instrument_code = $request->instrument_code;
        $portal_user_id = auth()->id();

        $contest_profiles = DB::table('contest_portfolios')
            ->where('portal_user_id', $portal_user_id)
            ->where('contests_id', $contests_id)
            ->where('instrument_code', $instrument_code)
            ->select('saleable_quantity')
            ->first();

        $validatedData = $request->validate([
            'instrument_code' => 'required',
            'quantity' => 'required|integer|min:1',
        ], [
            'instrument_code.required' => 'Please select an instrument code.',
            'quantity.required' => 'Please enter the quantity.',
            'quantity.integer' => 'Quantity must be an integer.',
            'quantity.min' => 'Quantity must be at least :min.',
        ]);

        if ($validatedData['quantity'] > $contest_profiles->saleable_quantity) {
            return redirect()->back()->with('sellerror', 'Insufficient quantity');
        }

        $instrument = Instrument::select('id', 'instrument_code', 'isin')->where('instrument_code', $request->instrument_code)->first();


        $contest = DB::table('contests')->where('id', $contests_id)->first();
        if ($contest->slug == env('Free_demo_slug', 'free-demo')) {
            $total_commision = floatval(DB::table('free_demo_broker')->where('user_id', '=', $portal_user_id)->value('commision_rate')) * floatval(DB::table('company_basic_information')->where('code', $request->instrument_code)->first()->market_price) * $request->quantity / 100;

        } else {
            $total_commision = floatval(DB::table('commissions')->first()->value) * floatval(DB::table('company_basic_information')->where('code', $request->instrument_code)->first()->market_price) * $request->quantity / 100;
        }


        $total_price = floatval(DB::table('company_basic_information')->where('code', $request->instrument_code)->first()->market_price) * $request->quantity;

        $data = $request->all();
        $data['side'] = 'S';
        $data['total_commision'] = $total_commision;
        $data['portal_user_id'] = auth()->id();
        $data['contests_id'] = $contests_id;
        $data['instrument_code'] = $request->instrument_code;
        $data['value'] = $total_price;
        $data['status'] = 'Fill';
        $data['isin'] = $instrument->isin;
        $data['board'] = 'PUBLIC';
        $data['fill_type'] = 'FILL';
        $data['category'] = 'A';
        $data['purchase_date'] = now()->toDateString(); // Use Carbon for consistent date formatting
        $data['purchase_time'] = now()->toTimeString(); // Use Carbon for consistent time formatting

        $status = ContestOrder::productorderprocess($data);

        // $portfolio = ContestPortfolio::where('portal_user_id', auth()->id())->where('contests_id', $contests_id)->where('instrument_code',$request->instrument_code)->first();
        // $neat_gain = ($portfolio->total_gain - $portfolio->total_loss) + $portfolio->total_sale_value - $portfolio->total_cost_value + (($portfolio->saleable_quantity + $portfolio->pending_holding_quantity) * $portfolio->current_avg_cost);
        // if ($neat_gain > 0) {
        //     $portfolio->total_gain = $neat_gain;
        //     $portfolio->total_loss = 0;
        // } else {
        //     $portfolio->total_loss = -1 * $neat_gain;
        //     $portfolio->total_gain = 0;
        // }
        // $portfolio->save();

        return redirect()->route('demo.contest.panel', $contest->slug)->with('message', 'Sell order successful');
    }

    public function deposit_amount(Request $request)
    {
        $portal_user_id = auth()->id();
        $contest = DB::table('contests')->where('slug', env('Free_demo_slug', 'free-demo'))->first();
        $contest_id = $contest->id;
        // dd($contest_id,$portal_user_id);


        $contest_profile = (array) DB::table('contest_profiles')
            ->where('contests_id', $contest_id)
            ->where('portal_user_id', $portal_user_id)
            ->first();

        $contest_profile['deposit_amount'] += $contest->amount;
        $contest_profile['balance'] += $contest->amount;

        DB::table('contest_profiles')
            ->where('contests_id', $contest_id)
            ->where('portal_user_id', $portal_user_id)
            ->update($contest_profile);



        $account_ledger = array(
            'contests_id' => $contest_id,
            'portal_user_id' => $portal_user_id,
            'instrument_code' => 0,
            'remark' => 'deposit',
            'quantity' => 0,
            'price' => 0,
            'credit' => $request->amount,
            'debit' => 0,
            'commission' => 0,
            'balance' => $contest_profile['balance'],
            'purchase_date' => now(),
            'purchase_time' => now()
        );

        // dd($account_ledger);

        $profile_ledger = ContestLedger::create($account_ledger);
        return redirect()->back();
    }



    public function profile()
    {
        $contestUserTypes = DB::table('contest_user_types')
            ->orderBy('title', 'asc')
            ->pluck('title', 'id');


        return view('demo_trade.profile', compact('contestUserTypes'));
    }

    public function update_profile(Request $request)
    {
        $customMessages = [
            'name.required' => 'Please enter your name',
            'email.required' => 'Please enter your email address',
            'email.email' => 'Please enter a valid email address',
            'mobile.required' => 'Please enter your phone number',
            'mobile.numeric' => 'Please enter a valid phone number',
            'mobile.digits' => 'Phone number must be 11 digits',
            'gender.required' => 'Please select your gender',
            'contest_user_type_id.required' => 'Please select a user type',
        ];

        $customRules = [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric|digits:11',
            'gender' => 'required',
            'contest_user_type_id' => 'required',
        ];

        $request->validate($customRules, $customMessages);

        $user = Auth::user();
        if ($user->mobile != $request->input('mobile')) {
            $user->is_phone_verified = 0;
        }
        $user->full_name = $request->input('name');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');
        $user->nid = $request->input('nid');
        $user->organization = $request->input('organization');
        $user->gender = $request->input('gender');
        $user->contest_user_type_id = $request->input('contest_user_type_id');
        $user->save();

        session()->flash('success', 'Profile updated successfully.');

        return redirect()->back();
    }


    public function change_password(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'The current password is incorrect.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully.');
    }


    public function update_brokerage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brokerHouse' => 'required',
            'branchName' => 'required',
            'portfolioName' => 'required',
            'commissionRate' => ['required', 'numeric', 'between:0,100'],
            'depositAmount' => 'required|numeric',
        ], [
            'brokerHouse.required' => 'Please enter the Broker House Name',
            'branchName.required' => 'Please enter the Branch Name',
            'portfolioName.required' => 'Please enter the Portfolio Name',
            'commissionRate.required' => 'Please enter the Commission Rate',
            'commissionRate.numeric' => 'Please enter a valid number for Commission Rate',
            'commissionRate.between' => 'Please enter a number between 0 and 100 for Commission Rate',
            'depositAmount.required' => 'Please enter the Deposit Amount',
            'depositAmount.numeric' => 'Please enter a valid number for Deposit Amount',
        ]);

        if ($validator->fails()) {
            session::flash('portfolioerror', true);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user_id = auth()->user()->id;

        DB::table('free_demo_broker')->updateOrInsert(
            ['user_id' => $user_id],
            [
                'broker_house_name' => $request->input('brokerHouse'),
                'branch_name' => $request->input('branchName'),
                'portfolio_name' => $request->input('portfolioName'),
                'deposite_amount' => $request->input('depositAmount'),
                'commision_rate' => $request->input('commissionRate'),
            ]
        );

        return redirect()->back();
    }



}
