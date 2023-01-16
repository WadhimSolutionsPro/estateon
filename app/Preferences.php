<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preferences extends Model
{
    //
    protected $table = 'preferences';
    protected $fillable = ['name'];
    
}
