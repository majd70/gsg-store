<?php

use App\Models\Order;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of (((((the event broadcasting channels )))))that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});//الديفولت تشانيل الخاصة ب البرودكاست نوتيفيكيشن

Broadcast::channel('orders', function ($user) { //$user is current authenthication user
    if ($user->type == 'super-admin' || $user->type == 'admin') {
        return true;
    }
    return true;
   // $order = Order::findOrFail($id);
   // return $user->id == $order->user_id;
});
