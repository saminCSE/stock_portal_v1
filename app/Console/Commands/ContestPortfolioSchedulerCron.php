<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\cron\ContestPortfolioScheduler;
use Illuminate\Support\Facades\Log;

class ContestPortfolioSchedulerCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contest_portfolio_scheduler:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'contest portfolio scheduler update every day';

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
        Log::info('contest_portfolio_scheduler:cron');
        $cronController = new ContestPortfolioScheduler();
        $cronController->pendingHoldingChange();
    }
}
