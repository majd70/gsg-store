<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Repostroies\Cart\CartReposotiry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Throw_;
use Throwable;

class CheckOutController extends Controller
{

    protected $cart;

    public function __construct(CartReposotiry $cart)
    {

        $this->cart = $cart;
    }



    public function create()
    {
        return view('front.checkout', [
            'cart' => $this->cart,
            'user' => Auth::user(),

        ]);
    }


    public function store(Request $request)
    {

        $request->validate([

            'billing_name' => ['required', 'string'],
            'billing_email' => 'required',
            'billing_address' => 'required',
            'billing_city' => 'required',
            'billing_country' => 'required',
            'billing_phone' => 'required',
        ]);

        DB::beginTransaction();

        try{
         $request->merge([
            'total'=>$this->cart->total(),
         ]) ;

        $order =  Order::create($request->all());



        foreach ($this->cart->all() as $item) {
            OrderItem::create([
                'order_id'=>$order->id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'price' => $item->product->price,
            ]);




        }


        DB::commit();//اعتماد العمليات طالما مصارش ايررور

        event(new OrderCreated($order));
        return redirect()->route('orders')->with('success',__('Order created '));

        }catch(Throwable $e){
             DB::rollBack();//التراجع عن العمليات في حالة وجود اكسبشن
             throw $e;
        }





    }
}
