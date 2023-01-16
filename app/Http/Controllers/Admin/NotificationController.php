<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Notifications\AccountActivated;
class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
           //
           if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $users = User::where('device_token', '!=', null)->with('roles')->get();
        return view('admin.notification.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     
    }
public function sendnotification(Request $request){

       //
        // $userdata=User::where('id', $data['to'])->first();
        // if($userdata->device_token){
        //     $notification['title']=$user->name;
        //     $notification['data']=['c_id'=>"$id", 'name'=>$userdata->name, 'email'=>$userdata->email, 'user_id'=>"$userdata->id", 'type'=>'message'];
        //     $notification['body']=$data['msg'];
        //     $userdata->notify(new AccountActivated($notification));
        // }

foreach($request->user as $user_id){    
            $notification['to']=$user_id;
            $notification['title']=$request->title;
            $notification['data']=['user_id'=>"$user_id", 'type'=>'admin_notification'];
            $notification['body']=$request->body;
           // $userdata->notify(new AccountActivated($notification));
           $this->send_notification($notification);        
}
return redirect()->route('admin.notification.index');
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
    public function send_notification($data){
        try{
        //    $data['to']="95";
            $user=User::where('id', $data['to'])->first(); 
            if($user->device_token){
               $notification['title']=$data['title'];
                    $notification['data']=$data['data'];
                    $notification['body']=$data['body'];
                    $user->notify(new AccountActivated($notification));
            }
            return response()->json(['code' => '101', 'id'=>$user->device_token, 'status' => true]);
        }catch(Exception $e){
            return response()->json(['code' => '101', 'status' => false]);
        }
       
    }
}
