<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    //
    protected $table = 'chat';
    protected $fillable = ['from', 'to', 'msg', 'type', 'viewed'];
    
    public function chatedwith(){
        return $this->belongsTo('App\User', 'to');
    }
    public function chatedfrom(){
        return $this->belongsTo('App\User', 'from');
    }
}
