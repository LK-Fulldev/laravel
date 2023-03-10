<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CallRestOverviewSendgrid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:callrestoverview';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call Rest API For Get Data Overview every FourHours.';

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
        return 0;
    }
}
