<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Property;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['user']=User::count();
        $data['rent']=Property::where('type', 'rent')->count();
        $data['sale']=Property::where('type', 'sale')->count();
        return view('home', compact('data'));
    }

    public function logout(Request $request) {
        //print 'aa'; die;
        Auth::guard('web')->logout();
        return redirect('/admin');
      }
}
