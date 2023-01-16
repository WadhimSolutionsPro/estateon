<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $table = 'amenities';
    protected $fillable = ['name'];
    //
    public function assigned_amenities()
    {
        return $this->hasMany('App\AssignedAmenities', 'amenity_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($amenity) { // before delete() method call this
             $amenity->assigned_amenities()->get()->each->delete();
             // do the rest of the cleanup...
        });
    }
}
