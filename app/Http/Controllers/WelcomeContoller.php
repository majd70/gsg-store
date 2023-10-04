<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeContoller extends Controller
{
    //ACTION
     public function welcome()
     {
        return view ('welcome');
     }
}
