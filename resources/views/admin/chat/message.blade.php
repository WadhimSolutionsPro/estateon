@extends('layouts.admin')
@section('content')
    <div class="messaging-area">
        <div class="container">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <div class="view-msg-area card">
                        <div class="mscrn-title card-header">
                            <h3 class="mb-0">Messaging Area</h3>
                        </div>
                        <div class="chat_area card-body">
                            <div class="chat_inner" id="msg_inner">
                            @foreach($messages as $message)

                                <div class="{{$message->fromuser->id ==$userid ? 'msg-receiver':'msg-sender'}}">
                                    <div class="msg-body">
                                        <p>{{$message->reply}}</p>
                                    </div>
                                    <div class="{{$message->fromuser->id ==$userid ? 'reciver-name':'sndr-name'}}">
                                        <span>{{$message->fromuser->name}}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="write-msg-area">
                            <div class="form-group">
                            <textarea class="form-control" id="msgbody" rows="2"></textarea>
                            </div>
                            <div class="send-msg">
                                <button class="btn msg-send btn-xs btn-primary" type="button" id="send_msg">
                                    Send
                                </button>
                            </div>
                            <input type="hidden" id="lastmsg_id" value="{{$lastmsg_id}}" name="lastmsg"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
@parent
<script>
    $(document).ready(function() {
        function latestchat(){
console.log($("#lastmsg_id").val())
let userid= <?php echo $userid; ?>;
let parameters={
    _token: "{{ csrf_token() }}",
    convid: <?php echo $convid; ?>,
    last_id: $("#lastmsg_id").val()
}
      $.ajax({
                type: 'POST',
                url: "{{ route('admin.conversation.lastest') }}",
                data: parameters,
                success: function(data) {
                    console.log(data)
                    console.log(data.data.lastmsg_id) 
                    if(data.status==true){
                        console.log(data.data.msg)
                        if(data.data.msg.length>0){ 
                        let chathtml="";
                        $("#lastmsg_id").val(data.data.lastmsg_id)
                        $.each(data.data.msg, function(index, value){
                            let class1=value.fromuser.id==userid ? 'msg-receiver':'msg-sender';
                            let class2=value.fromuser.id==userid ? 'reciver-name':'sndr-name';
                            chathtml += "<div class="+class1+">" 
                            chathtml += "<div class='msg-body'>"
                            chathtml += "<p>"+value.reply+"</p>"
                            chathtml += "</div>"
                            chathtml += "<div class="+class2+">"
                            chathtml += "<span>"+value.fromuser.name+"</span>"
                            chathtml += "</div>"
                            chathtml += "</div>"
                        })
                        $("#msg_inner").append(chathtml);
                        }
                    }
                }
            });
        }   
        $('#send_msg').click(function(){
           let msg= ($('#msgbody').val()).trim();
           let msg_length=msg.length;
           if(msg_length>0){
               let postdata={
                _token: "{{ csrf_token() }}",
                reply: msg,
                user_id_fk: <?php echo $userid; ?>,
                c_id_fk: <?php echo $convid; ?>
               }
              
           $.ajax({
                type: 'POST',
                url: "{{ route('admin.conversation.savemsg') }}",
                data: postdata,
                success: function(data) {
                    console.log(data)
                    if(data.status==true){
                        $('#msgbody').val("");
                        latestchat();
                    }
                }
            }); 
           }

        })   
        setInterval(function(){ latestchat() }, 3000);
    })
</script>
@endsection