<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{






    public function index()
    {
      $products= product::active()->paginate();

      return view('front.products,index',[
        'product'=>$products,
      ]);
    }

    public function show($slug)
    {
       $product=product::where('slug','=',$slug)->firstOrFail();
       return view('front.products.show',[
        'product'=>$product,
       ]);
    }

}
