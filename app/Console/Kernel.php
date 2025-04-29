<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // 👇 Add this line
        $schedule->command('simulate:move')->everyTenSeconds();
    }


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected $commands = [
        \App\Console\Commands\SimulateVehicleMovement::class,
    ];
    
}

