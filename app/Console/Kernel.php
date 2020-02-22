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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //* * * * * /usr/bin/php /www/wwwroot/gather/artisan schedule:run >> /dev/null 2>&1

        $schedule->command('command:spider')->dailyAt('05:30');
        //每天获取可用连接
        $schedule->command('command:torrentkitty')->dailyAt('08:30');

        //清除日志
        //$schedule->command('activitylog:clean')->daily();
        //UV统计
        $schedule->command('command:uv')->hourly();
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
