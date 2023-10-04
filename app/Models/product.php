<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use phpDocumentor\Reflection\Types\Nullable;
use Illuminate\Support\Str;
use NumberFormatter;

class product extends Model
{
    use HasFactory;
    use SoftDeletes;

    const STATUS_ACTIVE='active';
    const STATUS_DRAFT='draft';

    protected $fillable=[
          'name','slug', 'description','image_path','price','sale_price','quantity','width','height','length','weight','status','category_id'
    ];

    protected static function booted()
    {
      /*  static::addGlobalScope('active',function(Builder $builder){
              $builder->where('products.status','=','active');
        });
        */

    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('products.status','=','active');
    }

    public function scopePrice(Builder $builder ,$from ,$to=null)
    {
        $builder->where('products.price','>=',$from);
          if($to !== null){
            $builder->where('products.price','<=',$to);

          }
    }

    public static function validateRule()
    {
        return[
            'name'=>'required|max:255',
            'category_id'=>'required|int|exists:categories,id',
            'description'=>'nullable',
            'image'=>'nullable|image|dimensions:min_width=300,min_height=300',
            'price'=>'nullable|numeric|min:0',
            'sale_price'=>'nullable|numeric|min:0',
            'quantity'=>'nullable|int|min:0',
            'sku'=>'nullable|unique:products,sku',
            'width'=>'nullable|numeric|min:0',
            'height'=>'nullable|numeric|min:0',
            'length'=>'nullable|numeric|min:0',
            'weight'=>'nullable|numeric|min:0',
            'status'=>'in:'. self::STATUS_ACTIVE .','. self::STATUS_DRAFT ,



        ];
    }
    //Accessors :get{AttributeName}Attribute
    //model->image-url
    public function getImageUrlAttribute()
    {
        if(!$this->image_path){
            return asset('images/placeholder-image.png');
        }

        if(stripos($this->image_path,'http')===0){
            return $this->image_path;
        }

        return asset('uploads/'.$this->image_path);
    }

    //mutators:set{AttributeName}Attribute

    public function setNameAttribute($value){

         $this->attributes['slug']= Str::slug($value);

         $this->attributes['name']= Str::title($value);//كل كلمة بالاسم حيصير يبدأ بكابيتل لاتر حتى لو المستخدم دخلها سموول
    }

    public function getFormattedPriceAttribute()
    {
        $fromatter=new NumberFormatter(App::getLocale(),NumberFormatter::CURRENCY);
        return $fromatter->formatCurrency($this->price,'USD');

    }

    public function category(){
        return $this->belongsTo(category::class,'category_id','id')->withDefault();
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id')->withDefault();
    }
    public function ratings(){
          return $this->morphMany(Rating::class,'rateable');
    }


}
