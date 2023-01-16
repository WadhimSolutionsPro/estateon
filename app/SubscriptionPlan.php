<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $table = 'subsscription_plan';
    protected $fillable = ['name', 'price', 'time_in_monthes','features','status'];
}
