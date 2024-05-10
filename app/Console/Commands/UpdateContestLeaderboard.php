<?php

namespace App\Console\Commands;

use App\Http\Controllers\cron\ContestLeaderboard;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateContestLeaderboard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ContestLeaderboard:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the leaderboard of demo contest';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('ContestLeaderboard:update');
        $leaderboard = new ContestLeaderboard;
        $leaderboard->update();
        $this->info('Contest leaderboard has been successfully updated!');
    }
}
