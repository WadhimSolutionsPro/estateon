<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    //
    protected $table = 'conversation';
    protected $fillable = ['user_one', 'user_two', 'ip', 'property_id'];

    public function fromuser(){
        return $this->belongsTo('App\User', 'user_one');
    }
    public function touser(){
        return $this->belongsTo('App\User', 'user_two');
    }
    public function property(){
        return $this->belongsTo('App\Property', 'property_id');
    }
    public function assistant(){
        return $this->hasOne('App\AssignedAssistant', 'conversation_id');
    }
}
