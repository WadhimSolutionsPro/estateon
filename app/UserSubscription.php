<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    protected $table = 'user_subscription';
    protected $fillable = ['user_id', 'plan_id', 'payment_id', 'start_at', 'end_at', 'status', 'notes'];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
    public function plan(){
        return $this->belongsTo('App\SubscriptionPlan', 'plan_id');
    }
    public function payment(){
        return $this->belongsTo('App\Payment', 'payment_id');
    }
}
