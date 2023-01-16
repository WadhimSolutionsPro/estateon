<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Property;
use App\PropertyType;
use App\Vastu;
use App\Amenity;
use App\Preferences;
use App\Likes;
use App\Leads;
class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function detail($slug)
    {
        $data = [];
        $data['property'] = Property::where('slug', $slug)->withCount('likes')->with(['amenities.amenity_data', 'vastu.vastu_data', 'preferences.preferences_data', 'property_type.type_data', 'property_details', 'images'])->first();
        if($data['property'] == null){
            return redirect()->route('home.index');
        }
        // echo "<pre>"; print_r($data['property']->toArray());
        // exit;
        return view('estate.detail', compact('data'));
    }
    public function list(Request $request)
    {        
        $userId = "";
        if (Auth::guard('frontuser')->check()) {
            $userId = Auth::guard('frontuser')->id();
        }
        $params = $request->all();
        $data = [];
        $property = Property::where('approved', 1)->where('status', 1)->with(['amenities.amenity_data', 'vastu.vastu_data', 'preferences.preferences_data', 'owner.roles' => function ($query) {
            $query->select('name');
        }, 'property_type.type_data', 'property_details', 'images']);
        if ($userId != "") {
            $property->where('user_id', '!=', $userId)->withCount([
                'likes' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                    $query->select(DB::raw('IF(count(*) > 0, 1, 0)'));
                }
            ]);
        }
        $radius = 50;
        if (!empty($params['address_latitude']) && !empty($params['address_longitude'])) {
            // if ($params['distance'] != '') {
            //     $radius = $params['distance'];
            // }
            $property->selectRaw("id, name, user_id, description, address, slug, type, approved, status, ( 6371 * acos( cos( radians(?) ) * cos( radians( lat ) )* cos( radians( lng ) - radians(?)) + sin( radians(?) ) * sin( radians( lat ) ) )) AS distance", [$params['address_latitude'], $params['address_longitude'], $params['address_latitude']])
                ->having("distance", "<=", $radius)
                ->orderBy("distance", 'asc');
        }
        if (isset($params['type'])) {
            if ($params['type'] != "") {
                $property->Where('type', $params['type']);
            }
        }
        if (isset($params['property_type'])) {
            // if ($params['property_type'] != "") {
            //     $property->whereHas('property_type', function ($query)  use ($params) {
            //         $query->Where('type_id', $params['property_type']);
            //         $query->with('type_data');
            //     });
            // }
        }
        if (isset($params['bedroom'])) {
            if ($params['bedroom'] != 0) {
                $property->whereHas('property_details', function ($query)  use ($params) {
                    $query->where('bedroom', $params['bedroom']);
                });
            }
        }
        if (isset($params['bathroom'])) {
            if ($params['bathroom'] != 0) {
                $property->whereHas('property_details', function ($query)  use ($params) {
                    $query->where('bathroom', $params['bathroom']);
                });
            }
        }
        if (isset($params['balcony'])) {
            if ($params['balcony'] != 0) {
                $property->whereHas('property_details', function ($query)  use ($params) {
                    $query->where('balcony', $params['balcony']);
                });
            }
        }
        if (isset($params['kitchen'])) {
            if ($params['kitchen'] != '') {
                $property->whereHas('property_details', function ($query)  use ($params) {
                    $query->where('kitchen', $params['kitchen']);
                });
            }
        }
        if (isset($params['living_room'])) {
            if ($params['living_room'] != '') {
                $property->whereHas('property_details', function ($query)  use ($params) {
                    $query->where('living_room', $params['living_room']);
                });
            }
        }
        if (isset($params['furnished'])) {
            if ($params['furnished'] != '') {
                $property->whereHas('property_details', function ($query)  use ($params) {
                    $query->where('furnished', $params['furnished']);
                });
            }
        }
        if (isset($params['price'])) {
            if ($params['price'] != '') {
                $property->whereHas('property_details', function ($query)  use ($params) {
                    $query->whereBetween('price', [0, $params['price']]);
                });
            }
        }
        if (isset($params['vastu'])) {
            if ($params['vastu'] != '') {
                $property->whereHas('vastu', function ($query)  use ($params) {
                    $query->where('vastu_id', $params['vastu']);
                });
            }
        }
        if (isset($params['amenities'])) {
            $amenities = $params['amenities'];
            // echo gettype($amenities);
            // print_r($params['amenities']);
            // echo "netin";
            // exit;
            if (gettype($amenities) == 'array') {
                if (count($amenities) > 0) {
                    $property->whereHas('amenities', function ($query)  use ($amenities) {
                        $query->whereIn('amenity_id', $amenities);
                    });
                }
            }
        }
        if (isset($params['additional'])) {
            $additional = $params['additional'];
            if (gettype($additional) == 'array') {
                if (count($additional) > 0) {
                    $property->whereHas('preferences', function ($query)  use ($additional) {
                        $query->whereIn('preference_id', $additional);
                    });
                }
            }
        }
        if (isset($params['property_by'])) {
            $usertypearray = $params['property_by'];
            if (gettype($usertypearray) == 'array') {
                if (count($usertypearray) > 0) {
                    $property->whereHas('owner', function ($query) use ($usertypearray) {
                        $query->whereIs(implode(",", $usertypearray));
                    });
                }
            }
        }
        $data['property'] = $property->simplePaginate(10);
        $data['latest'] = Property::where('approved', 1)->where('status', 1)->with(['property_details', 'images'])->limit(3)->orderByDesc('created_at')->get();
        $data['vastu'] = Vastu::get();
        $data['property_types'] = PropertyType::get();
        $data['amenity'] = Amenity::get();
        $data['preferences'] = Preferences::get();
        $data['userroles'] = ['Agent', 'Builder', 'Broker', 'Owner'];
        return view('estate.list', compact('data', 'params'));
    }
    public function propertylike(Request $request)
    {
        try {
            $user_id = Auth::guard('frontuser')->id();
            $data = $request->all();
            $liked = false;
            $likes = Likes::where('user_id', $user_id)
                ->where('property_id', $data['property_id'])->first();
            if (!$likes) {
                $like = Likes::create([
                    'user_id' => $user_id,
                    'property_id' => $data['property_id']
                ]);
                $liked = true;
            } else {
                $delete = Likes::where('user_id', $user_id)
                    ->where('property_id', $data['property_id'])->delete();
                $liked = false;
            }
            return response()->json(['code' => '101', 'liked' => $liked, 'status' => true]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'code' => '102', 'error' => $e]);
        }
    }
    public function leadAdd(Request $request)
    {
        try {
            //$user_id = Auth::guard('frontuser')->id();
            $data = $request->all();            
            parse_str($data['data'], $data);
            //print_R($data); die;
            $name =  $data['name'];
            $email =  $data['email'];
            $phone =  $data['phone'];
            $message =  $data['message'];
            $propertyID =  $data['property_id'];
            $time = time();
            $query = Leads::create(['name'=>$name, 'email'=>$email, 'phone'=>$phone, 'message'=>$message, 'property_id'=>$propertyID, 'created_at'=> $time]);
            if($query){
                return response()->json(['code' => '101', 'success' => true]);
            }else{
                return response()->json(['code' => '101', 'success' => false]);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'code' => '102', 'error' => $e]);
        }
    }
}
