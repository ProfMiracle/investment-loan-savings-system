<?php

namespace App\Console\Commands;

use App\Http\Controllers\SavingsCronController;
use Illuminate\Console\Command;

class SaveCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'savings:autodebit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for those that need to e debited for savings and debit them';

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
     * @return mixed
     */
    public function handle()
    {
        return (new SavingsCronController())->cron();
    }
}
