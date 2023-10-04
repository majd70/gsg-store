<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\SemnReminderMailNotification;
use Carbon\Carbon;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendReminderMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    //بدي تبعث رسالة ناقائية لكل اليوزرز الي ماعملو تاكيد لللايميل من بعد م انشاو الحساب ب سبع ايام
    public function handle()
    {
       $users= User::whereNull('email_verified_at')
        ->whereDate('created_at','<=',Carbon::now()->subDays(7))
        ->get();

        Notification::send($users, new SemnReminderMailNotification);






    }
}
