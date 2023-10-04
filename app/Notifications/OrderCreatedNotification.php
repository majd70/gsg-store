<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;



class OrderCreatedNotification extends Notification
{
    use Queueable;
    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)//بستخدمو ل تمرير اي داتا لل نوتيفيكيشن كلاس
    {
        $this->order=$order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)//بتحدد شو ال التشانيل الي حبيعث نوتيفيكيشن من خلالها
    {
        //notification chanell :mail,database,nexmo(sms),broadcast,slack,(custom chanell)
        //النتويفايابل فاريابل هو انستانس من اليوزر مودل
        return
         [
            'database',
            FcmChannel::class,
            //'mail',
            //'broadcast'

        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) //هدول تلميثود بحدد شكل الداتا الي حتنبعث ل للتشانيل الخاصة فيها
    {
        return (new MailMessage)
                    ->subject('new order')
                   ->greeting(__('hello, :name',['name'=>$notifiable->name ?? '']))
                    ->line(__('A new order has been created (order #:number)',['number'=>$this->order->number]))
                    ->action('View Order', url('/'))
                    ->line('Thank you for shopping with us');
                  /*  ->view('',[  // هاي لو بدي استخدم فيو للايميل غير الفيو تاع اللاررافيل
                        'order'=>$this->order,
                    ]);
                    */
    }

    public function toDatabase($notifiable) //هدول تلميثود بحدد شكل الداتا الي حتنبعث ل للتشانيل الخاصة فيها
    {
           return [
             'title'=>__('New Order #:number',['number'=>$this->order->number]) ,
             'body' => __('A new order has been created (order #:number)',['number'=>$this->order->number]),
             'icon' =>'' ,
             'url'=> url('/') //where he go when click on notification,
           ];
    }


    public function toBroadcast($notifiable) //هدول تلميثود بحدد شكل الداتا الي حتنبعث ل للتشانيل الخاصة فيها
    {
           return new BroadcastMessage(
            [
            'title'=>__('New Order #:number',['number'=>$this->order->number]) ,
            'body' => __('A new order has been created (order #:number)',['number'=>$this->order->number]),
            'icon' =>'' ,
            'url'=> url('/') //where he go when click on notification,
          ]
          ) ;
    }

    public function toFcm($notifiable){
        return FcmMessage::create()
            //->setData(['data1' => 'value', 'data2' => 'value2'])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle(__('New Order'))
                ->setBody('Your account has been activated.')
                ->setImage('http://example.com/url-to-image-here.png'))
                ;

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
