<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignedAssistant extends Model
{
    protected $table = 'assigned_assistant';
    protected $fillable = ['conversation_id','user_id', 'property_id'];

    public function conversastion(){
        return $this->belongsTo('App\Conversation', 'conversation_id');
    }
    public function property(){
        return $this->belongsTo('App\Property', 'property_id');
    }

}
