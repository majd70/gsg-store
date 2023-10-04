<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\product;
use App\Repostroies\Cart\CartReposotiry;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * @var \ App\Repostroies\Cart\CartReposotiry

     */
    protected $cart;

    public function __construct(CartReposotiry $cart)
    {
        $this->cart = $cart;
    }

    public function index()
    {

        $cart = $this->cart->all();
        $sucsess =session()->get('success');
        return view('front.cart',[
            'cart'=> $cart,
            'success'=>$sucsess,
            'total'=>$this->cart->total(),
        ]);


    }

    public function store(Request $request){

         $request->validate([
            'product_id'=>['required','exists:products,id'],
            'quantity'=>['int','min:1'],
         ]);

        $this->cart->add($request->post('product_id'),$request->post('quantity'));

        return redirect()->back()->with('success',__('item added to cart'));

    }
}
