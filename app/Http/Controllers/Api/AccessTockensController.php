<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTockensController extends Controller
{
    public function store(Request $request){
        $request->validate([
           'username'=>['required'],
           'password'=>['required'],
           'device_name'=>['required'],
           'abilities'=>['nullable'],
        ]);

        $user=User::where('email',$request->username)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                "message"=>"invalid user name  or password",
            ],401);
        }


        //لو وصل لهان اليوزر يعني هو يوزر صحيح وموجود بالداتا بيز عشان هيك لازم اعطيه اكسس توكن
     $abilities=$request->input('abilities',['*']);

     if($abilities && is_string($abilities)){
           $abilities=explode(',',$abilities);//بتحول السترنق ل اريي وبتفصل العناصر مكان الفاصلة
     }

     $token=   $user->createToken($request->device_name,$abilities);//بنشء توكن مشفر وبخزنو بالداتا بيز

     $accessToken=PersonalAccessToken::findToken($token->plainTextToken);
     $accessToken->forceFill([
        'ip'=>$request->ip(),
     ])->save();


     return response()->json([
        'token'=>$token->plainTextToken, //التوكن بعد فك التشفير
        'user'=>$user,
     ]);
    }
    public function destroy(){

        $user =Auth::guard('sanctum')->user();
        //revoke(delete ) all user tokens (quait from all devices)
       // $user->tokens()->delete();
         //revoke(delete ) currrent user token (quait from current devices)
        $user->currentAccessToken()->delete();
    }




}


