<?php

namespace App\Console\Commands;

use App\Http\Controllers\Cron\EodCronController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


class DatabankEodCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DataBankEod:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add DataBankEod';

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
        Log::info('DataBankEod:add');
        $cronControllerforEod = new EodCronController();
        $cronControllerforEod->marketDateScheduler();
        info("Cron is working fine in Data Bank Eod!");
    }
}
