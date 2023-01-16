<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignedAmenities extends Model
{
    //
    protected $table = 'assigned_amenities';
    protected $fillable = ['amenity_id', 'property_id'];
    public function property()
    {
        return $this->belongsTo('App\Property', 'property_id');
    }
    public function amenity_data()
    {
        return $this->belongsTo('App\Amenity', 'amenity_id');
    }
}
