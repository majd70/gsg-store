<?php

namespace App\Models;

use App\Observers\OrderObserver;
use Carbon\Carbon ;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;

    protected $fillable = [

        'number',
        'user_id',
        'shipping',
        'discount',
        'tax',
        'total',
        'status',
        'payment_status',

        'billing_name',
        'billing_email',
        'billing_address',
        'billing_city',
        'billing_country',
        'billing_phone',

        'shipping_name',
        'shipping_email',
        'shipping_address',
        'shipping_city',
        'shipping_country',
        'shipping_phone',
        'notes',
    ];

    public static function booted(){
           static::observe(OrderObserver::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    public function products(){
        return $this->belongsToMany(product::class,'order_items')
        ->using(OrderItem::class)//مودل التيبل الوسيط
        ->as('items')//بدل ميسميلي علاقة التيبل الوسيط بايفوت بسميها الي بدبي اياه
        ->withPivot(['quantity','price']);//الكولم الي يرجعها من التيبل الوسيط;
    }
}
