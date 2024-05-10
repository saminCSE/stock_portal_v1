<?php

namespace App\Console\Commands;

use App\Http\Controllers\Cron\MarketScheduleSettingCronController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MarketScheduleSettingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'MarketSchedulerSetting:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add MarketSchedulerSetting';

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
        Log::info('MarketSchedulerSetting:add');
        $cronControllerforEod = new MarketScheduleSettingCronController();
        $cronControllerforEod->marketDateScheduler();
    }
}
