<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    public $timestamps = false;
    //
    protected $table = 'leads';
    protected $fillable = ['name', 'email', 'phone', 'message', 'property_id', 'created_at'] ;
    
    const UPDATED_AT = null;
  
}
