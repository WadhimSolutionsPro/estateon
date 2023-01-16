<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFilter extends Model
{
    //
    protected $table = 'user_filter';
    protected $fillable = ['user_id', 'filter'];
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
