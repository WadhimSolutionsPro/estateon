<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $fillable = ['user_id', 'txnid', 'amount', 'date', 'name', 'email', 'phone', 'plan_id'];
}
