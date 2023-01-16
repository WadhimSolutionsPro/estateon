<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConversationReply extends Model
{
    //
    protected $table = 'conversation_reply';
    protected $fillable = ['reply', 'user_id_fk', 'c_id_fk', 'ip', 'status'];

    public function fromuser(){
        return $this->belongsTo('App\User', 'user_id_fk');
    }
}
