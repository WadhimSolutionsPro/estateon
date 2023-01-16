<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Property;
use App\SubscriptionPlan;
use App\Content;
class PageController extends Controller
{
    public function aboutus(){
        return view('estate.about');
    }
    public function contact(){
        return view('estate.contactus');
    }
    public function faq(){
        return view('estate.faq');
    }
    public function pricing(){
        $plans= SubscriptionPlan::where('status', 1)->get();
        return view('estate.pricing', compact(['plans']));
    }
    public function tandc(){
        $content= Content::where('page_key', "terms")->first();
        return view('estate.tandc', compact(['content']));
    }
    public function userguide(){
        return view('estate.userguide');
    }
    public function wishlist(){
        $user_id = Auth::guard('frontuser')->id();
            $properties = Property::with(['amenities.amenity_data', 'vastu.vastu_data', 'preferences.preferences_data', 'property_type.type_data', 'property_details', 'images', 'owner.roles' => function ($query) {
                $query->select('name');
            }])->whereHas('likes', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })->withCount([
                'likes' => function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                    $query->select(DB::raw('IF(count(*) > 0, 1, 0)'));
                }
            ])->paginate(10);
            return view('estate.wishlist', compact('properties'));
    }
    public function paymentsuccess(){
        return view('estate.paymentssuccess');
    }
}
