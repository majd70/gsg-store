<?php

namespace App\Providers;

use App\Models\Role;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
         'App\Models\product' => 'App\Policies\ProducPolicy',
         'App\Models\Role' => 'App\Policies\RolePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
   /*  Gate::before(function($user,$ability){
             if($user->type=='super-admin'){
                return true;
             }
             if($user->type=='user'){
                return false;
             }
             //غير هيك بنفد الفنكشن الي تحت
        });

        foreach(config('abilities') as $key => $value){
            Gate::define($key,function($user) use ($key,$value){//اليوز ل استخدام فاريابيل داخل الكلوجر فنكشن
                $user->hasAbility($key);
            });
        }

*/
    }
}
