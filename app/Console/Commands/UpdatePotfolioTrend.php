<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\cron\UpdatePortfolioTrendController;
use Illuminate\Support\Facades\Log;

class UpdatePotfolioTrend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'PotfolioTrend:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        Log::info('PotfolioTrend:update');
        $portfoliotrend = new UpdatePortfolioTrendController;
        $portfoliotrend->update();
        $this->info('Portfolio Trend has been successfully updated!');
    }
}
