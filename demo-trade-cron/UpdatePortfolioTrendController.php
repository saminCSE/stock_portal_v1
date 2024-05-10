<?php

namespace App\Http\Controllers\cron;

use Illuminate\Http\Request;
use App\Models\PortfolioTrend;
use App\Models\ContestPortfolio;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UpdatePortfolioTrendController extends Controller
{
    public function update()
    {
        $running_contests = DB::table('contests')
            ->where('contest_start_date', '<', now())
            ->where('contest_end_date', '>', now())
            ->select('id', 'title')
            ->get();

        foreach ($running_contests as $running_contest) {
            $contest_users = DB::table('contest_portfolios')
                ->where('contests_id', $running_contest->id)
                ->groupBy('portal_user_id')
                ->select('portal_user_id')
                ->get();
            foreach ($contest_users as $contest_user) {
                $contest_profiles = DB::table('contest_profiles')
                    ->where('portal_user_id', $contest_user->portal_user_id)
                    ->where('contests_id', $running_contest->id)
                    ->select('balance', 'deposit_amount')
                    ->first();
                $totalReturnData = DB::table('contest_portfolios')
                    ->select("*")
                    ->where('portal_user_id', $contest_user->portal_user_id)
                    ->where('contests_id', $running_contest->id)
                    ->selectRaw('(saleable_quantity + pending_holding_quantity) * market_price AS single_instrument_current_value')
                    ->get();
                $totalMarketValue = $totalReturnData->sum('single_instrument_current_value');
                $totalPortfolioValue = $totalMarketValue + $contest_profiles->balance;

                $portfolioTrend = PortfolioTrend::where('portal_user_id', $contest_user->portal_user_id)
                    ->where('contests_id', $running_contest->id)
                    ->where('trend_date',  date('Y-m-d'))
                    ->first();

                if ($portfolioTrend) {
                    $portfolioTrend->portal_user_id = $contest_user->portal_user_id;
                    $portfolioTrend->contests_id = $running_contest->id;
                    $portfolioTrend->Cash = $contest_profiles->balance;
                    $portfolioTrend->market_value = $totalMarketValue;
                    $portfolioTrend->portfolio_value = $totalPortfolioValue;
                    $portfolioTrend->trend_date =  date('Y-m-d');

                    $portfolioTrend->save();
                } else {
                    $portfolioTrend = new PortfolioTrend;

                    $portfolioTrend->portal_user_id = $contest_user->portal_user_id;
                    $portfolioTrend->contests_id = $running_contest->id;
                    $portfolioTrend->Cash = $contest_profiles->balance;
                    $portfolioTrend->market_value = $totalMarketValue;
                    $portfolioTrend->portfolio_value = $totalPortfolioValue;
                    $portfolioTrend->trend_date =  date('Y-m-d');

                    $portfolioTrend->save();
                }






            }
        }

    }
}
