<?php

namespace App\Console;

use Exception;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\CallRestOverviewSendgrid::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // Cronjob For Call Sendgrid Overview
        try {
            $schedule->call('App\Http\Controller\EmailController@CallRestSendgrid')
                ->everyFourHours()
                ->before(
                    function () {
                        echo "start [" . \Carbon\Carbon::now()->format('Ymd H:i:s') . "]";
                    }
                )
                ->after(
                    function () {
                        echo "- Finished [" . \Carbon\Carbon::now()->format('Ymd H:i:s') . "] \r\n";
                    }
                );
        } catch (Exception $e) {
            echo "\r\n[Error]" . $e->getMessage() . "line:" . $e->getLine() . " \r\n";
            echo "- Finished [" . \Carbon\Carbon::now()->format('Ymd H:i:s') . "] \r\n";
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
