<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimonials extends Model
{
    //
    protected $table = 'testimonials';
    protected $fillable = ['customer_name', 'testimonial', 'rating', 'publish', 'customer_designation', 'image'];
  
}
