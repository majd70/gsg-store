<?php

namespace App\Repostroies\Cart;

interface CartReposotiry {

    public function all();

    public function add($item ,$qty=1);

    public function clear();

   // public function total();


}
