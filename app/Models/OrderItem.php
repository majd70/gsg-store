<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderItem extends Pivot
{
    use HasFactory;

    //protected $fillable=['product_id','quantity','price','order_id'];
    public $timesstamps=false;

    protected $table='order_items';

    public function order(){
        return $this->belongsTo(Order::class);
    }



    public function product(){
        return $this->belongsTo(product::class);

    }
}
