<?php

namespace App\Repostroies\Cart;

use App\Models\Cart;
use App\Models\product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Str;

class DatabaseReposotiry  implements CartReposotiry
{
    protected $items;

    public function __construct()
    {
        $this->items=collect([]);
    }

    public function all()
    {
        if($this->items->count()==0){

        return  Cart::where('cookie_id', $this->getCookieId())
        ->orWhere('user_id', Auth::id())
        ->get();
        }

        return $this->items;

    }

    public function add($item, $qty = 1)
    {
        return  Cart::updateOrCreate([

            'cookie_id' => $this->getCookieId(),
            'product_id' => ($item instanceof product) ? $item->id : $item,
        ],[


            'user_id' => Auth::id(),
            // quantity=quantity+$qty
            'quantity' => DB::raw('quantity +' . $qty), //raw يعني خام اترك الجملة زي مهي

        ]);
    }


    public function clear()
    {

        Cart::where('cookie_id', $this->getCookieId())
            ->orWhere('user_id', Auth::id())
            ->delete();
    }

    protected function getCookieId()
    {

        /*$id=Cookie::get('cart_cookie_id');

        if(!$id){
           $id=Str::uuid();
           Cookie::queue('cart_cookie_id',$id,60*24*30);

        }
        return $id;
        */

        $id = Cookie::get('cart_cookie_id');

        if (!$id) {
            $id = Str::uuid();
            Cookie::queue('cart_cookie_id', $id, 60 * 24 * 30);
        } else {
            Cookie::queue('cart_cookie_id', $id, 60 * 24 * 30);
        }
        return $id;
    }

    public function total(){
          $items=$this->all();
         return $items->sum(function($item){
             return $item->quantity * $item->product->price;
          });
    }
}
