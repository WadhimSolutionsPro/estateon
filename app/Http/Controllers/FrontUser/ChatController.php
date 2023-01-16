<?php

namespace App\Http\Controllers\FrontUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Conversation;
use App\ConversationReply;
use App\User;
use App\AssignedAssistant;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        // if (! Gate::any(['users_manage', 'assistance', 'property_manage'])) {
        //     return abort(401);
        // }
        $conversastion = Conversation::query();
        if ($id) {
            $conversastion->where('property_id', $id);
        }
        $queries = $conversastion->with(['fromuser', 'touser', 'property', 'assistant'])->paginate(10);
        $users = User::with(['roles']);
        $users->whereHas('roles', function ($query) {
            $query->where('name', 'assistant');
        });
        $assistants = $users->get();
        //    echo "<pre>"; print_r($queries->toarray()); 
        //    exit;
        return view('userdashboard.chat.index', compact(['queries', 'assistants']));
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

    public function assignassistant(Request $request)
    {
        $data = $request->all();
        $assignassistant = AssignedAssistant::create([
            'conversation_id' => $data['conversastion_id'],
            'user_id' => $data['user_id'],
            'property_id' => $data['property_id']
        ]);
        return response()->json(['status' => true, 'data' => $assignassistant]);
    }

    public function aaaignedqueries()
    {
        $userid = Auth::user()->id;
        // echo $userid;
        // exit;
        $assignedqueries = AssignedAssistant::where('user_id', $userid)->with(['conversastion.fromuser', 'property'])->paginate(10);
        // echo "<pre>"; print_r($assignedqueries->toArray());
        // exit;
        return view('userdashboard.chat.assignedqueries', compact(['assignedqueries']));
    }

    public function message($convid)
    {
        $userid = Auth::user()->id;
        $lastmsg_id=null;
        $messages = ConversationReply::where('c_id_fk', $convid)->with('fromuser')->orderBy("created_at", "desc")->paginate(50)->reverse();
        // echo "<pre>"; print_r($messages->toArray());
        // exit;
        if(count($messages)>0){
            $msgarray= $messages->toArray();
            $lastmsg_id= end($msgarray)['id'];
        }
        return view('userdashboard.chat.message', compact(['messages', 'userid', 'convid', 'lastmsg_id']));
    }

    public function savemessage(Request $request)
    {
        $data=$request->all();
        $message = ConversationReply::create([
            'reply'=>$data['reply'],
            'user_id_fk'=>$data['user_id_fk'],
            'c_id_fk'=>$data['c_id_fk'],
            'ip'=>'122.3.3.7',
            'status' => 0
        ]);
        return response()->json(['status' => true, 'data' => $message]);
    }

    public function getlatestmessages(Request $request){
        $data=$request->all();
        $userid = Auth::user()->id;
        $convid = $data['convid'];
        $lastmsg_id=$data['last_id'];
        $result=[];
        $messages = ConversationReply::where('c_id_fk', $convid)->where('id', '>', $lastmsg_id)->with('fromuser')->orderBy("created_at", "desc")->paginate(50)->reverse();
        if(count($messages)>0){
            $msgarray= $messages->toArray();
            $lastmsg_id= end($msgarray)['id'];
        }
        $result['msg']=$messages;
        $result['lastmsg_id']=$lastmsg_id;

        return response()->json(['status' => true, 'data' =>$result]);
    }

}
