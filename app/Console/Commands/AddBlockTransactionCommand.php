<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Cron\BlockTransactionCronController;
use Illuminate\Support\Facades\Log;

class AddBlockTransactionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'block-transaction:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add block transactions from URL';

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
        Log::info('block-transaction:add');
        $cronController = new BlockTransactionCronController();
        $cronController->addBlockTransactionByUrl();
        info("Cron is working fine in add block transaction file!");
    }
}
