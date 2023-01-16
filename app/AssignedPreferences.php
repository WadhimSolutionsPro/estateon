<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignedPreferences extends Model
{
    //
    protected $table = 'assigned_preferences';
    protected $fillable = ['preference_id', 'property_id'];
    public function property()
    {
        return $this->belongsTo('App\Property', 'property_id');
    }
    public function preferences_data()
    {
        return $this->belongsTo('App\Preferences', 'preference_id');
    }
}
