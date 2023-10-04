<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class category extends Model
{
   use HasFactory;
   use SoftDeletes;

   //some properity to setting the model (we use defult setting we can change it in defult case)

   protected $connection='mysql';

   protected $table='categories';//  ربط المودل ب تيبل معين وبكون معمول تلقائي اذا كتبت اسم تالمودل بصيغة المفرد من اسم التيبل

   protected $primaryKey='id';

   protected $keyType='int';

   public $increminting=true;//increment for primary key

   public $timesataps=true;

   protected $fillable=[ //بتحدد اسماء الكولوم الي ممكن تدخل عليهم داتا من فورم معين
    'name','parent_id','slug','description','status'
   ];

   protected $hidden=[ //الكولم الي ما بدي اياها ترجع بالجيسون
         'created_at','updated_at','deleted_at'
   ];


   protected $appends=[ //الكولم الي بدي اضيفها ع الجيسون ولازم تكون ب الاكسسيسور
        'original_name'
     ];


     protected static function booted(){
            //event
             static ::creating(function(category $category){
                     $category->slug=str::slug($category->name);
             });
     }


   //Accessors
   //1)-Exisit Attribute  get{AttributeName}Attribute
   //model->name
   public function getNameAttribute($value)
   {
    if($this->trashed())
    {
        return $value . '(Deleted)' ;
    }
    return $value;
   }

    //2)- NonExisit Attribute
    //model->original_name

    public function getOriginalNameAttribute()
    {
        return $this->attributes['name'];
    }

    public function products(){
        return $this->hasMany(product::class,'category_id','id');
    }

    public function children(){
        return $this->hasMany(category::class,'parent_id','id');
    }

    public function parent(){
        return $this->belongsTo(category::class,'parent_id','id')->withDefault([
            'name'=>'No Parent'
        ]);



    }


}





