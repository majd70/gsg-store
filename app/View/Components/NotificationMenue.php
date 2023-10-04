<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class NotificationMenue extends Component
{

    public $notifications;
    public $unread;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $user=Auth::user();
        $this->notifications=$user->notifications()->limit(5)->get(); // النوتيفيكيشن بروباريتي هي علاقة مبنية بللارافيل بين جدول اليوزر ةالنوتيفيكيشن ب مقدار واحد ل متعدد وبترجع كل النوتيفيكيشن المبعوثة لهذا اليوزر
        $this->unread =$user->unreadNotifications->count();//بترجع الاشعارات الغير مقروءة
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.notification-menue');
    }
}
