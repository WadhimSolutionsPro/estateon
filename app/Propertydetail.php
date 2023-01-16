<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Propertydetail extends Model
{
    //
    protected $table = 'property_details';
    protected $fillable = ['property_id','bedroom','bathroom','balcony', 'kitchen', 'living_room', 'furnished','plot_area', 'area_measurement', 'size', 'length', 'width', 'price', 'currency', 'property_category', 'property_feature', 'extra_notes'];
}
