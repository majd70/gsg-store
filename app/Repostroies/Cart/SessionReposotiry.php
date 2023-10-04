<?php
namespace App\Repostroies\Cart;

use Illuminate\Support\Facades\Session ;

class SessionReposotiry implements CartReposotiry{

    protected $key='cart';

    public function all(){
         return Session::get($this->key);

    }

    public function add($item ,$qty=1)
    {
         Session::push($this->key,$item);
    }


    public function clear(){

         Session::forget($this->key);

    }
}
