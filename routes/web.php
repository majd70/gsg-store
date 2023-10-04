<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CountriesController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\productsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController as ControllersProductsController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\WelcomeContoller;
use App\Http\Middleware\CheckUserType;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',  [HomeController::class, 'index'])->name('home');


/*Route::get('/', function () {
    return view('auth.login');
});
*/

Route::namespace('Admin')
    ->prefix('admin')
    ->middleware(['auth','auth.type:admin,super-admin'])//LOOK IN KERNEL FILE and checktype middleware
    ->group(
        function () {

            Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
            Route::get('/categories/create', [CategoriesController::class, 'create'])->name('categories.create');
            Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');
            Route::get('/categories/{id}', [CategoriesController::class, 'show'])->name('categories.show');
            Route::get('/categories/{id}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
            Route::put('/categories/{id}', [CategoriesController::class, 'update'])->name('categories.update');
            Route::delete('/categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');

            Route::get('/products/trash', [productsController::class, 'trash'])->name('products.trash');
            Route::put('/products/trash/{id?}', [productsController::class, 'restore'])->name('products.restore');
            Route::delete('/products/trash/{id?}', [productsController::class, 'forceDelete'])->name('products.forceDelete');


        }

    );
            Route::resource('admin/products', productsController::class)->middleware(['auth', 'password.confirm']); //  بعرف ال 7 راوترات الي فوق

            Route::resource('admin/roles', RolesController::class);

            Route::resource('admin/countries', CountriesController::class);





           Route::get('/products',[ControllersProductsController::class,'index'])->name('products');
           Route::get('/products/{slug}',[ControllersProductsController::class,'show'])->name('product.details');

           Route::get('/cart',[CartController::class,'index'])->name('cart');
           Route::post('/cart',[CartController::class,'store']);

           Route::get('/checkout',[CheckOutController::class,'create'])->name('checkout');
           Route::post('/checkout',[CheckOutController::class,'store']);

           Route::get('/orders',function(){
              return Order::all();
           })->name('orders');
          // Route::post('/orders',[CheckOutController::class,'store']);

          Route::get('admin/notifications',[NotificationController::class ,'index'])->name('notifications');
          Route::get('admin/notifications/{id}',[NotificationController::class ,'show'])->name('notifications.read');




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:admin,web'])->name('dashboard');

require __DIR__ . '/auth.php';


Route::prefix('admin')
->as('admin.')
->group(function(){ //for admin guard
    require __DIR__ . '/auth.php';

});






Route::post('ratings/{type}', [RatingController::class, 'store'])->where('type', 'profile|product');



//Auth::guard('web')->user() //curent user model

//Auth::guard('web')->check() //check if user auth

//Auth::guard('web')->id() //current user id












/*
Route::get('products','ProductsController@index');
Route::get('products/{name}/{catageroies?}','ProductsController@show');









//request method
//Route::get('/welcome/to/laravel','App\Http\Controllers\WelcomeContoller@welcome');
Route::get('/welcome.php',[WelcomeContoller::class, 'welcome']);//لازم تلاقي الاكستنشن عشان يشتغل
Route::get('/welcome2.php', 'WelcomeContoller@welcome');// فعل الكومنت ب ملف الراوتسيرفسبروفايدر

 //Route::POST();
 //ROUTE::PUT();
 //ROUTE::PATCH();
 //ROUTE::DELETE();
 //ROUTE::OPTION();


 //OTHER HELPER METHOD
   route::any('/any','WelcomeContoller@welcome');
   route::match(['post','delete'],'/match','WelcomeContoller@welcome');//مش حيشتغل لانو مش محطوط فيه جيت
   ROUTE::VIEW('/laravel','welcome');//لما اطلب الراوت المعين برجعلي الفيو المعين
   ROUTE::REDIRECT('/home','/');//عند طلب راوت معين يتم توجيهه لراوت معين
  //ROUTE::RESOURCE();
  //ROUTE::APIRESOURCE();
  //ROUTE::GROUP();*/
