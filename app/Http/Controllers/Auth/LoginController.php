<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Socialite;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    // Public function login(Request $request){
    //     $this->validate($request, [
    //         'email' => 'required', 'password' => 'required',
    //     ]);
    //     if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
    //        $user=Auth::user();
    //         if($user->isAdmin){
    //             return redirect()->intended(route('admin.home'));
    //         }else{
    //          Auth::logout();
    //          return redirect()->back() ->withInput($request->only('email', 'remember'))->withErrors(['email' => Lang::get('auth.failed')]);
    //         }
            
    //     }else{
    //         return redirect()->back()
    //         ->withInput($request->only('email', 'remember'))
    //         ->withErrors([
    //             'email' => Lang::get('auth.failed'),
    //         ]);
    //     }
    //  }
    
}
