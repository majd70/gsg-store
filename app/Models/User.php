<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPUnit\Framework\MockObject\Stub\ReturnStub;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasAbility($ability)
    {
        $roles = Role::whereRaw('roles.id IN (SELECT role_id FROM role_user WHERE user_id = ?)',[
            $this->id,
        ])->get();
        //select * From roles where id IN(SELECT role_id from role_user where user_id =?)
        //select * From roles INNER JOIN role_user ON roles.id=role_user.role_id where role_user.user_id = ?)
        foreach($roles as $role){
            if(in_array($ability,$role->abilities)){
                return true;
            }
        }
        return false;
    }

    public function profile(){
        return $this->hasOne(Profile::class,'user_id','id')->withDefault([
            'address'=>'not entered',
        ]);//الويذ ديفلت بتلغي العلاقة لو مكانش في داتا ب البروفايل او بتحد انت ديفلت ل كل باراميتر بالبروفايل لو كان مش موجود
    }

    public function roles(){
        return $this->belongsToMany(Role::class,'role_user','user_id','role_id','id','id')->withPivot([]);
    }

    public function country(){
        return $this->belongsTo(country::class)->withDefault();
    }


    public function products(){
        return $this->hasMany(product::class);
    }
/*
    public function routeNotificationForMail( $notification = null)//بعمل كستمايزيشن على النوتافييبل كلاس اتربيووت بالميل تشانيل
    {
      // return    $this->email_address;//يعني بقلو استخد عمود الايميل ادرسس
    }

    */

    public function deviceTokens(){
             return $this->hasMany(DeviceToken::class);
    }

    public function routeNotificationForFcm( $notification = null){
       return    $this->deviceTokens()->pluck('token')->toArray();
    }
}


