<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;

    public $incrementing=false;

    protected $KeyType='string';

    protected $fillable=['id','cookie_id','user_id','product_id','quantity'];

    protected $with=[ //هاي البروباريتي بكتب فيها العلاقة الي بدي يصير الها ايقر لودنق دائما كل م اطلب الكارت مودل
          'product',
    ];

    protected static function booted(){//هاي الفنكشن بتتنفذ مع كل عملية انشاء ل هذا المودل
        //event
          static::creating(function(Cart $cart){
             $cart->id=Str::uuid();
          });
    }

    public function product(){
        return $this->belongsTo(product::class);

    }
}
