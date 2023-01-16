<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    //
    protected $table = 'propertytypes';
    protected $fillable = ['name'];
}
