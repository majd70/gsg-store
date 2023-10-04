<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class country extends Model
{
    use HasFactory;


    public function users(){
        return $this->hasMany(User::class);
    }

    public function products(){
        return $this->hasManyThrough(
              product::class,
              User::class,
              'country_id',
            'user_id',
            'id',
            'id'

        );
    }
}
