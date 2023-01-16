<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ui extends Model
{
    protected $table = 'ui';
    protected $fillable = ['name', 'section'];
    public function uimeta(){
        return $this->hasMany('App\UiMeta', 'ui_id');
    }
}
