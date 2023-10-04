<?php
namespace App\Repostroies\Cart;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session ;

class CookieReposotiry  implements CartReposotiry{

    protected $name='cart';

    public function all(){
         $items= Cookie::get($this->name);

         if($items){
            return unserialize($items);//casting string
         }
         return[];
    }

    public function add($item ,$qty=1)
    {
        $items=$this->all();//بتقرا الكوكي الحالية ايش فيها عشان اضيف عليها
        $items[]=$item;
        Cookie::queue($this->name ,serialize($items),60*24*30);
    }


    public function clear(){

        Cookie::queue($this->name ,'',-60);


    }
}
