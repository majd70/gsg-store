<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\OrderInvoice;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class SendInoviceListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $order=$event->order;
        /* ل ارسال نوتيفيكيشن ل اكثر من يوزر بنفس الوقت
        $users=User::whereIn('type',['super-admin','admin'])->get();
        Notification::send($users,new OrderCreatedNotification($order));
        */

        //لارسال نوتيفيكيشن ل يوزر واحد
        $user=User::where('type','admin')->first();
        $user->notify(new OrderCreatedNotification($order));



        /*لارسال نوتيفيكيشن ل اشخاص مش مسجلين عندي بالموقع
        Notification::route('mail',['info@example.com','info2@example.com'])
        //->route('nexmo','+0292393839')
        ->notify(new OrderCreatedNotification($order));
        */



      //  Mail::to($order->billing_email)->send(new OrderInvoice($order));
    }
}
