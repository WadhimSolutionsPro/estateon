<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UiMetadata extends Model
{
    protected $table = 'ui_metadata';
    protected $fillable = ['ui_id', 'meta_name', 'ui_meta_id', 'meta_value'];

    
}
