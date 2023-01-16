<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentRequests extends Model
{
    //
    protected $table = 'agent_requests';
    protected $fillable = ['from', 'to', 'name', 'email', 'phone', 'type', 'property_id'];
    //
}
