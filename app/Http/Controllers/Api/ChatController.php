<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Chat;
use App\User;
use App\AgentRequests;
use App\ConversationReply;
use App\Conversation;
use App\Property;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Notifications\AccountActivated;
use Carbon\Carbon;
use JWTAuth;
use Auth;
use Exception;

class ChatController extends Controller
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
    public function create(Request $request)
    {
        //
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['code' => '103', 'error' => 'user_not_found', 'status' => false]);
            }
            $data = $request->all();
            $onversation_exist = Conversation::where('user_one', $user->id)
                ->where('user_two', $data['to'])
                ->orWhere('user_one', $data['to'])
                ->where('user_two', $user->id)->first();
            $id = "";
            if (!$onversation_exist) {
                $conversation = Conversation::create([
                    'user_one' => $user->id,
                    'user_two' => $data['to'],
                    'ip' => '122.3.3.7'
                ]);
                $id = $conversation->id;
            } else {
                $id = $onversation_exist->id;
            }

            $conversation_reply = ConversationReply::create([
                'user_id_fk' => $user->id,
                'c_id_fk' => $id,
                'reply' => $data['msg'],
                'ip' => '122.3.3.7',
                'status' => 0
            ]);
            if ($conversation_reply) {
                $userdata=User::where('id', $data['to'])->first();
                if($userdata->device_token){
                    $data['username']=$user->name;
                    $data['c_id']=$id;
                    $this->sendnotification($data);
                    // $notification['title']=$user->name;
                    // $notification['data']=['c_id'=>"$id", 'name'=>$userdata->name, 'email'=>$userdata->email, 'user_id'=>"$userdata->id", 'type'=>'message'];
                    // $notification['body']=$data['msg'];
                    // $userdata->notify(new AccountActivated($notification));
                }
             return response()->json(['code' => '101', 'msg' => $conversation_reply, 'status' => true]);
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['success' => false, 'error' => 'Token is Invalid', 'code' => '102']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['success' => false, 'error' => 'Token is Expired', 'code' => '102']);
            } else {
                return response()->json(['success' => false, 'code' => '102', 'error'=>$e]);
            }
        }
    }




    public function createconversastion(Request $request){
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['code' => '103', 'error' => 'user_not_found', 'status' => false]);
            }
            $data = $request->all();
            $conversation = Conversation::where('property_id', $data['property_id'])
                ->where('user_one', $user->id)
                ->where('user_two', $data['to'])
                ->orWhere('user_one', $data['to'])
                ->where('user_two', $user->id)
                ->first();
                $id = "";
            if (!$conversation) {
                $conversation = Conversation::create([
                    'user_one' => $user->id,
                    'user_two' => $data['to'],
                    'property_id' => $data['property_id'],
                    'ip' => '122.3.3.7'
                ]);
                $id = $conversation->id;
            } else {
                $id = $conversation->id;
            }
            return response()->json(['code' => '101', 'error'=>$data['property_id'], 'msg' => $conversation, 'status' => true]);
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['success' => false, 'error' => 'Token is Invalid', 'code' => '102']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['success' => false, 'error' => 'Token is Expired', 'code' => '102']);
            } else {
                return response()->json(['success' => false, 'code' => '102', 'error'=>$e]);
            }
        }
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

    public function getlist(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['code' => '103', 'error' => 'user_not_found', 'status' => false]);
            }
            $data = $request->all();
            $user_id = $user->id;
            $chat_info = DB::select(DB::raw("SELECT U.id,C.id as c_id, C.user_two as reciever, U.name,U.email, U.avatar FROM users U,conversation C WHERE
            (CASE WHEN C.user_one = " . $user->id . "
            THEN C.user_two = U.id
            WHEN C.user_two = " . $user->id . "
            THEN C.user_one = U.id
            END) AND (
                C.user_one ='$user->id'
                OR C.user_two ='$user->id'
            )
         ORDER BY C.id DESC"));
            foreach ($chat_info as $index=>&$chat) {
                $chat->lastmsg = ConversationReply::where('c_id_fk', $chat->c_id)
                    ->orderBy('id', 'DESC')->first();
                    $chat->unread=ConversationReply::where('c_id_fk', $chat->c_id)->where('user_id_fk',$chat->reciever)
                    ->where('status', 0)->count();
                    if(!$chat->lastmsg){
                        unset($chat_info[$index]);
                    }
            }
            usort($chat_info, function ($a, $b) {
                if ($a->lastmsg->created_at == $b->lastmsg->created_at) {
                    return 0;
                }
     
                return ($a->lastmsg->created_at < $b->lastmsg->created_at) ? 1 : -1;
             });
            return response()->json(['code' => '101', 'msg' => $chat_info, 'status' => true]);
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['success' => false, 'error' => 'Token is Invalid', 'code' => '102']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['success' => false, 'error' => 'Token is Expired', 'code' => '102']);
            } else {
                return response()->json(['success' => false, 'code' => '102', 'error' => $e]);
            }
        }
    }

    public function agentcontact(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['code' => '103', 'error' => 'user_not_found', 'status' => false]);
            }
            $data = $request->all();
            $create_request = AgentRequests::create([
                'from' => $user->id,
                'name' => $data['name'],
                'to' => $data['owner_id'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'property_id' => $data['property_id'],
                'type' => $data['type']
            ]);
            if ($create_request) {
                return response()->json(['code' => '101', 'data' => $create_request, 'status' => true]);
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['success' => false, 'error' => 'Token is Invalid', 'code' => '102']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['success' => false, 'error' => 'Token is Expired', 'code' => '102']);
            } else {
                return response()->json(['success' => false, 'code' => '102']);
            }
        }
    }

    public function getchat(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['code' => '103', 'error' => 'user_not_found', 'status' => false]);
            }
            $data = $request->all();
            $userchat = DB::select(DB::raw("SELECT R.id,R.reply,U.id as user_id,U.name,U.email, U.avatar
            FROM users U, conversation_reply R
            WHERE R.user_id_fk=U.id AND R.c_id_fk=" . $data['c_id'] . "
            ORDER BY R.id ASC"));
            return response()->json(['code' => '101', 'msg' => $userchat, 'status' => true]);
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['success' => false, 'error' => 'Token is Invalid', 'code' => '102']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['success' => false, 'error' => 'Token is Expired', 'code' => '102']);
            } else {
                return response()->json(['success' => false, 'code' => '102', 'error'=>$e]);
            }
        }
    }

    public function markmsgread(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['code' => '103', 'error' => 'user_not_found', 'status' => false]);
            }
            $data = $request->all();
            $c_id = $data['c_id'];
            // $conversastion=ConversationReply::where('user_id_fk', '!=', $user->id)
            // ->where('c_id_fk', $c_id)->first();
           // if($conversastion){
                ConversationReply::where('user_id_fk', '!=', $user->id)
                ->where('c_id_fk', $c_id)
                ->update(['status' => 1]);
          //  }          
            return response()->json(['code' => '101', 'status' => true]);
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['success' => false, 'error' => 'Token is Invalid', 'code' => '102']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['success' => false, 'error' => 'Token is Expired', 'code' => '102']);
            } else {
                return response()->json(['success' => false, 'code' => '102', 'error'=>$e]);
            }
        }
    } 
    public function sendnotification($data){
        try{
        //    $data['to']="95";
            $user=User::where('id', $data['to'])->first(); 
            if($user->device_token){
               $notification['title']=$data['username'];
               $id=$data['c_id'];
                    $notification['data']=['c_id'=>"$id", 'name'=>$user->name, 'email'=>$user->email, 'user_id'=>"$user->id", 'type'=>'message'];
                    $notification['body']=$data['msg'];
                    $user->notify(new AccountActivated($notification));
            }
            return response()->json(['code' => '101', 'id'=>$user->device_token, 'status' => true]);
        }catch(Exception $e){
            return response()->json(['code' => '101', 'id'=>$e, 'status' => false]);
        }
       
    }
}
