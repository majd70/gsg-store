<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{

    protected $guard='web';

    public function __construct(Request $request)
    {
        if($request->is('admin/*')){
            $this->guard='admin';
        }
    }
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login',[
            'guard'=>$this->guard,
            'route'=>$this->guard=='admin'? route('admin.login') :route('login'),
        ]);

    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->guard=$this->guard;
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);//انتنديد يعني بوديك ع الصفجة الي حاولت تصللها قبل متعمل لوقن والبراميتر هي الصفحة الي بتروحلها بعد متعمل لوقن بشكل طبيعي
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();



        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
