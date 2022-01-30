<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //'App\Console\Commands\TestCron',
        //'App\Console\Commands\SaveCron',
        Commands\SaveCron::class,
        Commands\TestCron::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('test:interest')->everyMinute()
             ->runInBackground()
             ->emailOutputTo('alelechi17@gmail.com');
         $schedule->command('savings:autodebit')->hourly()
             ->runInBackground()
             ->emailOutputTo('alelechi17@gmail.com');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
