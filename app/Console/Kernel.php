<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        //csv毎分取り込み
        //$schedule->command('csv:import 0')
        //->everyMinute()
        //->appendOutputTo(dirname(dirname(dirname(__FILE__))) . '/storage/logs/SampleSchedule.log')
        //->onSuccess(function () {
        //    Log::info('成功');
        //})
        //->onFailure(function () {
        //    Log::error('エラー');
        //})
        //;
        $schedule->command('sitemap:create')->dailyAt('00:00');
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
