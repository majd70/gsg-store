<?php

namespace App\Console;

use App\Jobs\SendReminderMailJob;
use App\Notifications\SemnReminderMailNotification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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

        /*
         for run queue in live server
              $schedule->command('queue:work',[
                '--stop-when-empty'=>null,

              ])->everyMinute();

        */

         $schedule->job( new SendReminderMailJob,'mail')->everyTwoMinutes();//الجوب فنكشن بتقدر تحط فيها كمان براميتر الي هو ب اي  كيويو تحط الجوب
         $schedule->job( new SendReminderMailJob,'lunsh')->everyTwoMinutes();
         $schedule->job( new SendReminderMailJob)->everyTwoMinutes();
         $schedule->job( new SendReminderMailJob)->everyTwoMinutes();
         $schedule->job( new SendReminderMailJob)->everyTwoMinutes();
         $schedule->job( new SendReminderMailJob)->everyTwoMinutes();

         $schedule->job( new SendReminderMailJob)->everyTwoMinutes();

         $schedule->job( new SendReminderMailJob)->everyTwoMinutes();








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
