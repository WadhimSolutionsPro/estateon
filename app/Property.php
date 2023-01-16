<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    //
    protected $table = 'properties';
    protected $fillable = ['name', 'user_id', 'description', 'address', 'location', 'lat', 'lng', 'type', 'email', 'website', 'contact_number', 'status', 'featured', 'notes', 'hot', 'sort', 'approved', 'slug', 'created_by'];
    protected $hidden = [
        'email', 'website', 'contact_number',
    ];
    public function amenities()
    {
        return $this->hasMany('App\AssignedAmenities', 'property_id');
    }
    public function vastu(){
        return $this->hasOne('App\AssignedVastu', 'property_id');
    }
    public function preferences(){
        return $this->hasMany('App\AssignedPreferences', 'property_id');
    }
    public function property_details(){
        return $this->hasOne('App\Propertydetail', 'property_id');
    }
    public function property_type(){
        return $this->hasOne('App\AssignedTypes', 'property_id');
    }
    public function images(){
        return $this->hasMany('App\Images', 'property_id');
    }
    public function likes(){
        return $this->hasMany('App\Likes', 'property_id');
    }
    public function owner(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($amenity) { // before delete() method call this
             $amenity->amenities()->get()->each->delete();
             $amenity->vastu()->get()->each->delete();
             $amenity->preferences()->get()->each->delete();
             $amenity->property_details()->get()->each->delete();
             $amenity->property_type()->get()->each->delete();
             $amenity->images()->get()->each->delete();
             $amenity->likes()->get()->each->delete();
             // do the rest of the cleanup...
        });
    }
}
