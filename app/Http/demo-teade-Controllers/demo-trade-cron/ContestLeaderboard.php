<?php

namespace App\Http\Controllers\cron;

use App\Models\ContestRank;
use Illuminate\Http\Request;
use App\Models\ContestProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ContestLeaderboard extends Controller
{
    public function update()
    {
        $running_contests = DB::table('contests')
            ->where('contest_start_date', '<', now())
            ->where('contest_end_date', '>', now())
            ->select('id', 'title')
            ->get();

        foreach ($running_contests as $running_contest) {
            $sorted_contest_users = DB::table('contest_portfolios')
                ->where('contests_id', $running_contest->id)
                ->select(
                    'portal_user_id',
                    DB::raw('SUM(COALESCE(total_gain, 0)) - SUM(COALESCE(total_loss, 0)) as profit'),
                    DB::raw('SUM(COALESCE(total_gain, 0)) as total_gain'),
                    DB::raw('SUM(COALESCE(total_loss, 0)) as total_loss')
                )
                ->groupBy('portal_user_id')
                ->orderBy('profit', 'desc')
                ->get();

            // dd($sorted_contest_users);
            $rank = 1;
            foreach ($sorted_contest_users as $sorted_contest_user) {
                $transactioncount = DB::table('contest_orders')
                    ->where('contests_id', $running_contest->id)
                    ->where('portal_user_id', $sorted_contest_user->portal_user_id)
                    ->count();
                $deposit_amount = DB::table('contest_profiles')
                    ->where('contests_id', $running_contest->id)
                    ->where('portal_user_id', $sorted_contest_user->portal_user_id)
                    ->value('deposit_amount');
                $total_buy_amount = DB::table('contest_orders')
                    ->where('contests_id', $running_contest->id)
                    ->where('portal_user_id', $sorted_contest_user->portal_user_id)
                    ->where('side', 'B')
                    ->value(DB::raw('SUM(value)'));

                if ($transactioncount >= 0 && (($total_buy_amount / $deposit_amount) * 100) >= 0) {
                    $contest_profile = ContestProfile::where('contests_id', $running_contest->id)
                        ->where('portal_user_id', $sorted_contest_user->portal_user_id)
                        ->first();
                    if ($contest_profile) {
                        $contest_profile->rank_position = $rank;
                        $contest_profile->save();

                        $contest_rank = new ContestRank;
                        $contest_rank->portal_user_id =$sorted_contest_user->portal_user_id;
                        $contest_rank->contests_id = $running_contest->id;
                        $contest_rank->rank_position = $rank;
                        $contest_rank->rank_date = now();
                        $contest_rank->total_gain = $sorted_contest_user->total_gain;
                        $contest_rank->total_loss = $sorted_contest_user->total_loss;
                        $contest_rank->save();


                        $rank = $rank + 1;
                    }
                }
            }

        }
    }
}
