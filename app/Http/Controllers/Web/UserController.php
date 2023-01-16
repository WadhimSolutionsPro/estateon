<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Property;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function agents()
    {
        $user = User::whereIs('Agent', 'Builder', 'Broker', 'Owner')->with(['roles'])->withCount(['properties' => function ($query) {
            $query->where('status', 1)->where('approved', 1);
        }])->paginate(10);
        $data['latest'] = Property::where('approved', 1)->where('status', 1)->with(['property_details', 'images'])->limit(3)->orderByDesc('created_at')->get();
        // echo "<pre>";
        // print_r($user->toArray());
        return view('estate.agentlist', compact(['user', 'data']));
    }

    public function userdetail($slug)
    {
        $userId = "";
        if (Auth::guard('frontuser')->check()) {
            $userId = Auth::guard('frontuser')->id();
        }
        $data['user'] = User::where('slug', $slug)->with(['roles'])->with(['properties' => function ($query) use ($userId) {
            $query->where('approved', 1)->where('status', 1)->with(['images', 'property_details', 'property_type.type_data']);
            if ($userId != "") {
                $query->where('user_id', '!=', $userId)->withCount([
                    'likes' => function ($quer) use ($userId) {
                        $quer->where('user_id', $userId);
                        $quer->select(DB::raw('IF(count(*) > 0, 1, 0)'));
                    }
                ]);
            }
        }])->withCount(['properties' => function ($query) {
            $query->where('status', 1)->where('approved', 1);
        }])->first();
        return view('estate.agentdetail', compact(['data']));
        // echo "<pre>";
        // print_r($data['user']->toArray());
    }
}
