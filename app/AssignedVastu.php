<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignedVastu extends Model
{
    //
    protected $table = 'assigned_vastu';
    protected $fillable = ['vastu_id', 'property_id'];
    public function property()
    {
        return $this->belongsTo('App\Property', 'property_id');
    }
    public function vastu_data()
    {
        return $this->belongsTo('App\Vastu', 'vastu_id');
    }
}
