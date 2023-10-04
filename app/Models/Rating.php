<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

 protected $fillable=[
    'rateable_type',
    'reteable_id',
    'rating'

 ];
 public function rateable(){
     return $this->morphTo('rateable');
 }

}
