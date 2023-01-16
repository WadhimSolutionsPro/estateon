<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignedTypes extends Model
{
    //
    protected $table = 'assigned_type';
    protected $fillable = ['type_id', 'property_id'];
    public function property()
    {
        return $this->belongsTo('App\Property', 'property_id');
    }
    public function type_data()
    {
        return $this->belongsTo('App\PropertyType', 'type_id');
    }
}
