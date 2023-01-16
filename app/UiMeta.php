<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UiMeta extends Model
{
    protected $table = 'ui_meta';
    protected $fillable = ['ui_id', 'element_name'];
    public function uimetadata(){
        return $this->hasMany('App\UiMetadata', 'ui_meta_id');
    }
}
