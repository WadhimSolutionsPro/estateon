<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Property;
use App\PropertyType;
use App\Vastu;
use App\Amenity;
use App\Preferences;
use App\Propertydetail;
use App\AssignedVastu;
use App\AssignedAmenities;
use App\AssignedPreferences;
use App\AssignedTypes;
use App\Likes;
use App\UserFilter;
use Illuminate\Http\Request;
use JWTAuth;
use Auth;
use Exception;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;
use Requests;
use Validator;

class PropertiesController extends Controller
{
    public function addstep1(Request $request)
    {
        // try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['code' => '103', 'error' => 'user_not_found', 'status' => false]);
            }


            $validationArray = array(
                'type' => 'required',
                'property_category' => 'required', // new done
                'property_type' => 'required',
                'property_name' => 'required', // new done
                'description' => 'required',
                'address' => 'required',
                'lat' => 'required',
                'lng' => 'required',
                'amenities' => 'required|string',
                'preference' => '', // new done
                'vastu' => '',
                'property_feature' => 'required',
                'furnished' => 'required|in:unfurnished,furnished,semi_furnished', // new done*
                'size' => 'required',
                'width' => 'required',
                'length' => 'required',
                'price' => 'required',
                'govt_tax_include' => 'required|boolean', // new done
                'extra_notes' => '' // new done
            );
 
            $validator = Validator::make($request->all(),
                $validationArray
            ); 

            if ($validator->fails()) {
                $errorMessage = null;
                foreach ($validator->errors()->getMessages() as $error) {
                    $errorMessage = $error[0];
                    break;
                }
                $errorReturnArray = ['success' => false, 'error' => $errorMessage, 'code' => '102'];
                return response()->json($errorReturnArray);
            }

            

            $data = $request->all();
            //$amenities = json_decode($data['amenities']);
            $amenities = array_map('trim', explode(',', $data['amenities']));
            //print_r($amenities); die;

            // return response()->json(['code' => '101', 'data' => gettype($amenities), 'status' => true]);
            $user_id = $user->id;
            $sort = 0;
            if ($user_id == 73) {
                $sort = 1;
            } 

            
            $property = Property::create([
                'user_id' => $user_id,
                'name' => $data['property_name'],
                'description' => $data['description'],
                'address' => $data['address'],
                'lat' => $data['lat'],
                'lng' => $data['lng'],
                'type' => $data['type'],
                'status' => 0,
                'featured' => 0,
                //'notes' => $data['notes'],
                'sort' => $sort,
                'created_by' => $user_id
            ]);
            $property_id = $property->id;

            ///Vastu///
            $vastu = isset($data['vastu']) ? $data['vastu'] : "";
            if ($vastu != "") {
                $assign_vastu = AssignedVastu::create([
                    'vastu_id' => $vastu,
                    'property_id' => $property_id
                ]);
            }
            ///property type
            $property_type = $data['property_type'];
            if ($property_type != '') {
                $assign_type = AssignedTypes::create([
                    'type_id' => $property_type,
                    'property_id' => $property_id
                ]);
            }
            ////Amenities
            //$amenities = isset($data['amenities']) ? json_decode($data['amenities']) : [];
            $amenities = $data['amenities'];
            if (gettype($amenities) == 'array') {
                $insert_ammenity = [];
                if (count($amenities) > 0) {
                    foreach ($amenities as $value) {
                        $values = [];
                        $values['amenity_id'] = $value;
                        $values['property_id'] = $property_id;
                        $values["created_at"] = Carbon::now();
                        $values["updated_at"] = now();
                        array_push($insert_ammenity, $values);
                    }
                    AssignedAmenities::insert($insert_ammenity);
                }
            }
            ///Additional
            $additional =  isset($data['additional']) ?  json_decode($data['additional']) : [];
            if (gettype($additional) == 'array') {
                $insert_additional = [];
                if (count($additional) > 0) {
                    foreach ($additional as $value) {
                        $values = [];
                        $values['preference_id'] = $value;
                        $values['property_id'] = $property_id;
                        $values["created_at"] = Carbon::now();
                        $values["updated_at"] = now();
                        array_push($insert_additional, $values);
                    }
                    AssignedPreferences::insert($insert_additional);
                }
            }

            $extraNotes = isset($data['extra_notes']) ? $data['extra_notes'] : '';

            ////property details
            $property_details = Propertydetail::create([
                'property_id' => $property_id,
                'property_category' => $data['property_category'],
                'property_feature' => $data['property_feature'],
                //'bedroom' => $data['bedroom'],
                //'bathroom' => $data['bathroom'],
                //'balcony' => $data['balcony'],
                //'kitchen' => $data['kitchen'],
                //'living_room' => $data['living_room'],
                'furnished' => $data['furnished'],
                'preference' => isset($data['preference']) ? $data['preference'] : '',
                'size' => $data['size'],
                'length' => $data['length'],
                'width' => $data['width'],
                'price' => $data['price'],
                //'currency' => $data['currency'],
                'govt_tax_include' => $data['govt_tax_include'],
                'extra_notes' => $extraNotes
            ]);

            return response()->json(['code' => '101', 'proprty_id' => $property_id, 'status' => true]);
        // } catch (Exception $e) {
        //     if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
        //         return response()->json(['success' => false, 'error' => 'Token is Invalid', 'code' => '102']);
        //     } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
        //         return response()->json(['success' => false, 'error' => 'Token is Expired', 'code' => '102']);
        //     } else {                
        //         return response()->json(['success' => false, 'code' => '102', 'error' => $e]);
        //     }
        // }
    }


    public function updateProperty(Request $request)
    {

        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['code' => '103', 'error' => 'user_not_found', 'status' => false]);
            }


            $validationArray = array(
                'property_id' => 'required',
                'type' => 'required',
                'property_category' => 'required', // new done
                'property_type' => 'required',
                'property_name' => 'required', // new done
                'description' => 'required',
                'address' => 'required',
                'lat' => 'required',
                'lng' => 'required',
                'amenities' => 'required|string',
                'preference' => '', // new done
                'vastu' => '',
                'property_feature' => 'required',
                'furnished' => 'required|in:unfurnished,furnished,semi_furnished', // new done*
                'size' => 'required',
                'width' => 'required',
                'length' => 'required',
                'price' => 'required',
                'govt_tax_include' => 'required|boolean', // new done
                'extra_notes' => '' // new done
            );

            $validator = Validator::make($request->all(),
                $validationArray
            );

            if ($validator->fails()) {
                $errorMessage = null;
                foreach ($validator->errors()->getMessages() as $error) {
                    $errorMessage = $error[0];
                    break;
                }
                $errorReturnArray = ['success' => false, 'error' => $errorMessage, 'code' => '102'];
                return response()->json($errorReturnArray);
            }

            

            $data = $request->all();
            // $amenities = json_decode($data['amenities']);
            $amenities = array_map('trim', explode(',', $data['amenities']));

            // return response()->json(['code' => '101', 'data' => gettype($amenities), 'status' => true]);
            $user_id = $user->id;
            $sort = 0;
            if ($user_id == 73) {
                $sort = 1;
            } 

            $propertyCount = Property::where('id',$data['property_id'])->count();
            if($propertyCount == 0){
                return response()->json(['success' => false, 'error' => 'Property ID does not exists', 'code' => '102']);
            }
            $property = Property::where('id',$data['property_id'])->update([
                'user_id' => $user_id,
                'name' => $data['property_name'],
                'description' => $data['description'],
                'address' => $data['address'],
                'lat' => $data['lat'],
                'lng' => $data['lng'],
                'type' => $data['type'],
                'status' => 0,
                'featured' => 0,
                //'notes' => $data['notes'],
                'sort' => $sort
            ]);
            //$property_id = $property->id;
            $property_id = $data['property_id'];

            ///Vastu///
            $vastu = isset($data['vastu']) ? $data['vastu'] : "";
            if ($vastu != "") {
                $assign_vastu = AssignedVastu::where('property_id',$property_id)->update([
                    'vastu_id' => $vastu
                ]);
            }
            ///property type
            $property_type = $data['property_type'];
            if ($property_type != '') {
                $assign_type = AssignedTypes::where('property_id',$property_id)->update([
                    'type_id' => $property_type
                ]);
            }
            ////Amenities            
            $amenities = $data['amenities'];
            if (gettype($amenities) == 'array') {
                $insert_ammenity = [];
                if (count($amenities) > 0) {
                    AssignedAmenities::where('property_id',$property_id)->delete();
                    foreach ($amenities as $value) {
                        $values = [];
                        $values['amenity_id'] = $value;
                        $values['property_id'] = $property_id;
                        $values["created_at"] = Carbon::now();
                        $values["updated_at"] = now();
                        array_push($insert_ammenity, $values);
                    }
                    AssignedAmenities::insert($insert_ammenity);
                }
            }
            ///Additional
            $additional =  isset($data['additional']) ?  json_decode($data['additional']) : [];
            if (gettype($additional) == 'array') {
                $insert_additional = [];
                if (count($additional) > 0) {
                    AssignedPreferences::where('property_id',$property_id)->delete();
                    foreach ($additional as $value) {
                        $values = [];
                        $values['preference_id'] = $value;
                        $values['property_id'] = $property_id;
                        $values["created_at"] = Carbon::now();
                        $values["updated_at"] = now();
                        array_push($insert_additional, $values);
                    }
                    AssignedPreferences::insert($insert_additional);
                }
            }

            $extraNotes = isset($data['extra_notes']) ? $data['extra_notes'] : '';
            ////property details
            $property_details = Propertydetail::where('property_id',$property_id)->update([
                'property_category' => $data['property_category'],
                'property_feature' => $data['property_feature'],
                //'bedroom' => $data['bedroom'],
                //'bathroom' => $data['bathroom'],
                //'balcony' => $data['balcony'],
                //'kitchen' => $data['kitchen'],
                //'living_room' => $data['living_room'],
                'furnished' => $data['furnished'],
                'preference' => isset($data['preference']) ? $data['preference'] : '',
                'size' => $data['size'],
                'length' => $data['length'],
                'width' => $data['width'],
                'price' => $data['price'],
                //'currency' => $data['currency'],
                'govt_tax_include' => $data['govt_tax_include'],
                'extra_notes' => $extraNotes,
            ]);

            return response()->json(['code' => '101', 'proprty_id' => $property_id, 'status' => true]);
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['success' => false, 'error' => 'Token is Invalid', 'code' => '102']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['success' => false, 'error' => 'Token is Expired', 'code' => '102']);
            } else {
                return response()->json(['success' => false, 'code' => '102', 'error' => $e]);
            }
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['code' => '103', 'error' => 'user_not_found', 'status' => false]);
            }
            $properties = Property::where('status', 1)->where('approved', 1)->with(['amenities.amenity_data', 'vastu.vastu_data', 'preferences.preferences_data', 'property_type.type_data', 'property_details', 'images', 'owner.roles' => function ($query) {
                $query->select('name');
            }])->withCount([
                'likes' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                    $query->select(DB::raw('IF(count(*) > 0, 1, 0)'));
                }
            ])->orderByDesc('sort')->orderByDesc('created_at')->paginate(10);
            return response()->json(['code' => '101', 'response' => $properties, 'status' => true]);
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['success' => false, 'error' => 'Token is Invalid', 'code' => '102']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['success' => false, 'error' => 'Token is Expired', 'code' => '102']);
            } else {
                return response()->json(['success' => false, 'code' => '102', 'error' => $e]);
            }
        }
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
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['code' => '103', 'error' => 'user_not_found', 'status' => false]);
            }
            $data = $request->all();
            $property_id = $data['property_id'];
            $property = Property::where('id', $property_id)->first();
            if ($property->user_id != $user->id) {
                return response()->json(['code' => '103', 'error' => 'You cannot edit this property', 'status' => false]);
            }
            $update_property = [
                'description' => $data['description'],
                'address' => $data['address'],
                'lat' => $data['lat'],
                'lng' => $data['lng'],
                'type' => $data['type'],
                'status' => 1,
                'featured' => 0,
                'notes' => $data['notes']
            ];
            Property::where('id', $data['property_id'])
                ->update($update_property);

            ///Vastu///
            $vastu = $data['vastu'];
            $assigned_vastu = AssignedVastu::where('property_id', $property_id)->delete();
            if ($vastu != "") {
                $assign_vastu = AssignedVastu::create([
                    'vastu_id' => $vastu,
                    'property_id' => $property_id
                ]);
            }
            ///property type
            $property_type = $data['property_type'];
            $assigned_types = AssignedTypes::where('property_id', $property_id)->delete();
            if ($property_type != '') {
                $assign_type = AssignedTypes::create([
                    'type_id' => $property_type,
                    'property_id' => $property_id
                ]);
            }
            ////Amenities
            $amenities = json_decode($data['amenities']);
            $assigned_amenities = AssignedAmenities::where('property_id', $property_id)->delete();
            if (gettype($amenities) == 'array') {
                $insert_ammenity = [];
                if (count($amenities) > 0) {
                    foreach ($amenities as $value) {
                        $values = [];
                        $values['amenity_id'] = $value;
                        $values['property_id'] = $property_id;
                        $values["created_at"] = Carbon::now();
                        $values["updated_at"] = now();
                        array_push($insert_ammenity, $values);
                    }
                    AssignedAmenities::insert($insert_ammenity);
                }
            }
            ///Additional
            $additional = json_decode($data['additional']);
            $assigned_additional = AssignedPreferences::where('property_id', $property_id)->delete();
            if (gettype($additional) == 'array') {
                $insert_additional = [];
                if (count($additional) > 0) {
                    foreach ($additional as $value) {
                        $values = [];
                        $values['preference_id'] = $value;
                        $values['property_id'] = $property_id;
                        $values["created_at"] = Carbon::now();
                        $values["updated_at"] = now();
                        array_push($insert_additional, $values);
                    }
                    AssignedPreferences::insert($insert_additional);
                }
            }
            $update_details = [
                //'bedroom' => $data['bedroom'],
                //'bathroom' => $data['bathroom'],
                //'balcony' => $data['balcony'],
                //'kitchen' => $data['kitchen'],
                //'living_room' => $data['living_room'],
                'furnished' => $data['furnished'],
                'size' => $data['size'],
                'length' => $data['length'],
                'width' => $data['width'],
                'price' => $data['price'],
                //'currency' => $data['currency']
            ];
            Propertydetail::where('property_id', $data['property_id'])
                ->update($update_details);

            return response()->json(['code' => '101', 'status' => true]);
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['success' => false, 'error' => 'Token is Invalid', 'code' => '102']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['success' => false, 'error' => 'Token is Expired', 'code' => '102']);
            } else {
                return response()->json(['success' => false, 'code' => '102', 'error' => $e]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        //
    }

    public function getpropertyfeatures(Request $request)
    {

        $data = $request->all();
           


            // $validationArray = array(
            //     'property_type' => 'in:commercial',
            // );

            // $validator = Validator::make($request->all(),
            //     $validationArray
            // );

            // if ($validator->fails()) {
            //     $errorMessage = null;
            //     foreach ($validator->errors()->getMessages() as $error) {
            //         $errorMessage = $error[0];
            //         break;
            //     }
            //     $errorReturnArray = ['success' => false, 'error' => $errorMessage, 'code' => '102'];
            //     return response()->json($errorReturnArray);
            // }

            // $propertyType = $request->property_type;
        
        try {
            

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['code' => '103', 'error' => 'Invalid token', 'status' => false]);
            }
            $vastu = Vastu::get();
            $property_types_residential = PropertyType::where('property_type','residential')->get();
            $property_types_commercial = PropertyType::where('property_type','commercial')->get();
            $property_types = array('residential'=>$property_types_residential,'commercial'=>$property_types_commercial);
            $amenity_residential = Amenity::where('property_type','residential')->get();
            $amenity_commercial = Amenity::where('property_type','commercial')->get();
            $amenity = array('residential'=>$amenity_residential,'commercial'=>$amenity_commercial);
            $preferences = Preferences::get();
            $userroles = ['Agent', 'Builder', 'Broker', 'Owner'];
            return response()->json(['code' => '101', 'vastu' => $vastu, 'amenities' => $amenity, 'types' => $property_types, 'preferencres' => $preferences, 'user_roles' => $userroles, 'status' => true]);
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['success' => false, 'error' => 'Token is Invalid', 'code' => '102']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['success' => false, 'error' => 'Token is Expired', 'code' => '102']);
            } else {
                return response()->json(['success' => false, 'code' => '102']);
            }
        }
    }

    public function myproperties(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['code' => '103', 'error' => 'Invalid token', 'status' => false]);
            }
            $user_id = $user->id;

            
                // "type": "commercial",
                // "property_category": "category",
                // "property_type": "abc",
                // "property_name": "New name",
                // "description": "Description",
                // "address": "Address",
                // "lat": "15",
                // "lng": "14",
                // "amenities": "abc",
                // "specifications": "New ones",
                // "vastu": "Here",
                // "property_feature": "New feature",
                // "furnished": "furnished",
                // "size": "15",
                // "width": "10",
                // "length": "56",
                // "govt_tax_include": true,
                // "price": "500",
                // "extra_notes": "No"
            

            $properties = Property::with(
                'amenities.amenity_data',
                'vastu.vastu_data',
                'preferences.preferences_data',
                'property_type.type_data',
                'property_details',
                'images'
            )->withCount([
                'likes' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                    $query->select(DB::raw('IF(count(*) > 0, 1, 0)'));
                }
            ])->where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate(10);
            return response()->json(['code' => '101', 'response' => $properties, 'status' => true]);
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['success' => false, 'error' => 'Token is Invalid', 'code' => '102']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['success' => false, 'error' => 'Token is Expired', 'code' => '102']);
            } else {
                return response()->json(['success' => false, 'code' => '102']);
            }
        }
    }


    public function filter(Request $request)
    {

        $validationArray = array(
            'type' => 'string|in:rent,buy',     //done
            'property_name' => 'string',        //done
            'property_category' => 'string|in:residential,commercial',  //done
            'property_type' => 'string',    // comma seperated  //done
            'property_by' => 'string',    // comma seperated    //done
            //'distance' => 'string', // later
            'furnished' => 'string',    //done
            'min_price' => 'string',    //done
            'max_price' => 'string',    //done
            'vastu' => 'string',    //done
            'amenities' => 'string',    // comma seperated  //done
        );

        $validator = Validator::make($request->all(),
            $validationArray
        );

        if ($validator->fails()) {
            $errorMessage = null;
            foreach ($validator->errors()->getMessages() as $error) {
                $errorMessage = $error[0];
                break;
            }
            $errorReturnArray = ['success' => false, 'error' => $errorMessage, 'code' => '102'];
            return response()->json($errorReturnArray);
        }

        //try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['code' => '103', 'error' => 'Invalid token', 'status' => false]);
            }
            $data = $request->all();
            $property = Property::where('status', 1)->where('approved', 1)->with(['amenities.amenity_data', 'vastu.vastu_data', 'preferences.preferences_data', 'property_type.type_data', 'images', 'owner.roles' => function ($query) {
                $query->select('name');
            }, 'property_details'])->whereHas('property_details')->withCount([
                'likes' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                    $query->select(DB::raw('IF(count(*) > 0, 1, 0)'));
                }
            ]);
            $radius = 30;
            if (isset($data['lat']) && isset($data['lng'])) {
                if ($data['distance'] != '') {
                    $radius = $data['distance'];
                }
                $property->selectRaw("( 6371 * acos( cos( radians(?) ) * cos( radians( lat ) )* cos( radians( lng ) - radians(?)) + sin( radians(?) ) * sin( radians( lat ) ) )) AS distance", [$data['lat'], $data['lng'], $data['lat']])
                    ->having("distance", "<=", $radius)
                    ->orderBy("distance", 'asc');
            }
            if (isset($data['type'])) {
                if ($data['type'] != "") {
                    $property->Where('type', $data['type']);
                }
            }
            if (isset($data['property_name'])) {
                if ($data['property_name'] != "") {
                    $property->Where('name', $data['property_name']);
                }
            }
            
            if (isset($data['property_category'])) {                                    
                //print $data['property_category']; die;
                $property->whereHas('property_details', function ($query)  use ($data) {
                    $query->where('property_category', $data['property_category']);
                });                
            }
            // $propertiey =  $property->get();
            // print_r($propertiey); die;

            if (isset($data['property_type'])) {
                if ($data['property_type'] != "") {
                    $propertyTypes = array_map('trim', explode(',', $data['property_type']));
                    $typesIDsArray=[];
                    foreach($propertyTypes as $propertyType){
                        $propertyData=PropertyType::where('name',$propertyType)->first();
                        if($propertyData != null){
                            $typesIDsArray[]=$propertyData->id;
                        }                        
                    }
                    if(count($typesIDsArray)>0){
                        $property->whereHas('property_type', function ($query)  use ($typesIDsArray) {
                            $query->whereIn('type_id', $typesIDsArray);
                            $query->with('type_data');
                        });
                    }
                }
            }

            if (isset($data['bedroom'])) {
                if ($data['bedroom'] != 0) {
                    $property->whereHas('property_details', function ($query)  use ($data) {
                        $query->where('bedroom', $data['bedroom']);
                    });
                }
            }
            if (isset($data['bathroom'])) {
                if ($data['bathroom'] != 0) {
                    $property->whereHas('property_details', function ($query)  use ($data) {
                        $query->where('bathroom', $data['bathroom']);
                    });
                }
            }
            if (isset($data['balcony'])) {
                if ($data['balcony'] != 0) {
                    $property->whereHas('property_details', function ($query)  use ($data) {
                        $query->where('balcony', $data['balcony']);
                    });
                }
            }
            if (isset($data['kitchen'])) {
                if ($data['kitchen'] != '') {
                    $property->whereHas('property_details', function ($query)  use ($data) {
                        $query->where('kitchen', $data['kitchen']);
                    });
                }
            }
            if (isset($data['living_room'])) {
                if ($data['living_room'] != '') {
                    $property->whereHas('property_details', function ($query)  use ($data) {
                        $query->where('living_room', $data['living_room']);
                    });
                }
            }
            if (isset($data['furnished'])) {
                if ($data['furnished'] != '') {
                    $property->whereHas('property_details', function ($query)  use ($data) {
                        $query->where('furnished', $data['furnished']);
                    });
                }
            }
            if (isset($data['min_price'])) {
                if ($data['min_price'] != '') {
                    $property->whereHas('property_details', function ($query)  use ($data) {
                        $query->where('price', '>=' ,$data['min_price']);
                    });
                }
            }
            if (isset($data['max_price'])) {
                if ($data['max_price'] != '') {
                    $property->whereHas('property_details', function ($query)  use ($data) {
                        $query->where('price', '<=' ,$data['max_price']);
                    });
                }
            }
            if (isset($data['minprice']) && isset($data['maxprice'])) {
                if ($data['minprice'] != '' && $data['maxprice'] != '') {
                    $property->whereHas('property_details', function ($query)  use ($data) {
                        $query->whereBetween('price', [$data['minprice'], $data['maxprice']]);
                    });
                }
            }


            //    if(isset($data['sort_type'])){
            //     if($data['sort_type'] == "HL"){
            //         $property->whereHas('property_details', function ($query)  use ($data) {
            //              $query->orderBy('price', 'DESC');
            //         });
            //     }

            //     if($data['sort_type'] == "LH"){
            //         $property->whereHas('property_details', function ($query)  use ($data) {
            //              $query->orderBy('price', 'ASC');
            //         });
            //     }
            //   }




            if (isset($data['vastu'])) {
                if ($data['vastu'] != '') {                    
                    // $vastuTypes = array_map('trim', explode(',', $data['vastu']));                    
                    // $vastuIDsArray=[];
                    // foreach($vastuTypes as $vastuType){
                    //     $vastuData=Vastu::where('name',$vastuType)->first();
                    //     if($vastuData != null){
                    //         $vastuIDsArray[]=$vastuData->id;
                    //     }                        
                    // }

                    $vastuIDS = array_map('trim', explode(',', $data['vastu']));                    
                    $vastuIDsArray=[];
                    foreach($vastuIDS as $vastuID){
                        $vastuData=Vastu::where('id',$vastuID)->first();
                        if($vastuData != null){
                            $vastuIDsArray[]=$vastuData->id;
                        }                        
                    }
                    if(count($vastuIDsArray)>0){
                        $property->whereHas('vastu', function ($query)  use ($vastuIDsArray) {
                            $query->whereIn('vastu_id', $vastuIDsArray);
                        });
                    }                    
                }
            }
            if (isset($data['amenities'])) {
                $amenities = array_map('trim', explode(',', $data['amenities']));
                // echo gettype($amenities);
                // print_r($data['amenities']);
                // echo "netin";
                // exit;

                $amenitiesIDsArray=[];
                foreach($amenities as $amenity){
                    $aminityData=Amenity::where('name',$amenity)->first();
                    if($aminityData != null){
                        $amenitiesIDsArray[]=$aminityData->id;
                    }                        
                }

                if(count($amenitiesIDsArray)>0){
                    $property->whereHas('amenities', function ($query)  use ($amenitiesIDsArray) {
                        $query->whereIn('amenity_id', $amenitiesIDsArray);
                    });
                }
            }
            if (isset($data['additional'])) {
                $additional = json_decode($data['additional']);
                if (gettype($additional) == 'array') {
                    if (count($additional) > 0) {
                        $property->whereHas('preferences', function ($query)  use ($additional) {
                            $query->whereIn('preference_id', $additional);
                        });
                    }
                }
            }
            if (isset($data['property_by'])) {
                if (strlen($data['property_by']) > 3) {
                    // $userty = str_replace(array('[', ']'), '', $data['property_by']);
                    // $usertypearray = explode(',', $userty);
                    $usertypearray = array_map('trim', explode(',', $data['property_by']));

                    if (gettype($usertypearray) == 'array') {
                        if (count($usertypearray) > 0) {
                            foreach ($usertypearray as $index => $value) {
                                $usertypearray[$index] = trim($value);
                            }
                            $property->join('users', 'users.id', '=', 'properties.user_id')
                                ->join('assigned_roles', 'assigned_roles.entity_id', '=', 'users.id')
                                ->join('roles', 'roles.id', '=', 'assigned_roles.role_id')
                                ->whereIn('roles.name', $usertypearray);
                        }
                    }
                }
            }


            $filter_userarray = ['lat' => isset($data['lat']) ? $data['lat'] : NULL, 'lng' => isset($data['lng']) ? $data['lng'] : NULL, 'type' => isset($data['type']) ? $data['type'] : NULL];
            $filterdata = UserFilter::firstOrNew(array('user_id' => $user->id));
            $filterdata->filter = serialize($filter_userarray);
            $filterdata->save();

            if (isset($data['sort_type'])) {
                if ($data['sort_type'] == "NEW") {
                    $property->orderBy("created_at", "desc");
                } elseif ($data['sort_type'] == "HL") {
                    $property->orderByRaw("(SELECT price FROM `property_details` where property_details.property_id=properties.id) DESC");
                } else {
                    $property->orderByRaw("(SELECT price FROM `property_details` where property_details.property_id=properties.id) ASC");
                }
            }


            $propertiey =  $property->get();
            //$dataarray=$propertiey->toArray();
            // $collection =collect($dataarray);

            // print_r($propertiey->toArray());
            return response()->json(['code' => '101', 'data' => $propertiey, 'status' => true]);
        // } catch (Exception $e) {
        //     if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
        //         return response()->json(['success' => false, 'error' => 'Token is Invalid', 'code' => '102']);
        //     } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
        //         return response()->json(['success' => false, 'error' => 'Token is Expired', 'code' => '102']);
        //     } else {
        //         return response()->json(['success' => false, 'code' => '102', 'error' => $e]);
        //     }
        // }
    }

    // public function filter(Request $request)
    // {
    //     try {
    //         if (!$user = JWTAuth::parseToken()->authenticate()) {
    //             return response()->json(['code' => '103', 'error' => 'Invalid token', 'status' => false]);
    //         }
    //         $data = $request->all();
    //         $property = Property::where('status', 1)->where('approved', 1)->with(['amenities.amenity_data', 'vastu.vastu_data', 'preferences.preferences_data', 'property_type.type_data', 'images', 'owner.roles' => function ($query) {
    //             $query->select('name');
    //         }, 'property_details'])->whereHas('property_details')->withCount([
    //             'likes' => function ($query) use ($user) {
    //                 $query->where('user_id', $user->id);
    //                 $query->select(DB::raw('IF(count(*) > 0, 1, 0)'));
    //             }
    //         ]);
    //         $radius = 30;
    //         if (isset($data['lat']) && isset($data['lng'])) {
    //             if ($data['distance'] != '') {
    //                 $radius = $data['distance'];
    //             }
    //             $property->selectRaw("( 6371 * acos( cos( radians(?) ) * cos( radians( lat ) )* cos( radians( lng ) - radians(?)) + sin( radians(?) ) * sin( radians( lat ) ) )) AS distance", [$data['lat'], $data['lng'], $data['lat']])
    //                 ->having("distance", "<=", $radius)
    //                 ->orderBy("distance", 'asc');
    //         }
    //         if (isset($data['type'])) {
    //             if ($data['type'] != "") {
    //                 $property->Where('type', $data['type']);
    //             }
    //         }
    //         if (isset($data['property_type'])) {
    //             if ($data['property_type'] != "") {
    //                 $property->whereHas('property_type', function ($query)  use ($data) {
    //                     $query->Where('type_id', $data['property_type']);
    //                     $query->with('type_data');
    //                 });
    //             }
    //         }
    //         if (isset($data['bedroom'])) {
    //             if ($data['bedroom'] != 0) {
    //                 $property->whereHas('property_details', function ($query)  use ($data) {
    //                     $query->where('bedroom', $data['bedroom']);
    //                 });
    //             }
    //         }
    //         if (isset($data['bathroom'])) {
    //             if ($data['bathroom'] != 0) {
    //                 $property->whereHas('property_details', function ($query)  use ($data) {
    //                     $query->where('bathroom', $data['bathroom']);
    //                 });
    //             }
    //         }
    //         if (isset($data['balcony'])) {
    //             if ($data['balcony'] != 0) {
    //                 $property->whereHas('property_details', function ($query)  use ($data) {
    //                     $query->where('balcony', $data['balcony']);
    //                 });
    //             }
    //         }
    //         if (isset($data['kitchen'])) {
    //             if ($data['kitchen'] != '') {
    //                 $property->whereHas('property_details', function ($query)  use ($data) {
    //                     $query->where('kitchen', $data['kitchen']);
    //                 });
    //             }
    //         }
    //         if (isset($data['living_room'])) {
    //             if ($data['living_room'] != '') {
    //                 $property->whereHas('property_details', function ($query)  use ($data) {
    //                     $query->where('living_room', $data['living_room']);
    //                 });
    //             }
    //         }
    //         if (isset($data['furnished'])) {
    //             if ($data['furnished'] != '') {
    //                 $property->whereHas('property_details', function ($query)  use ($data) {
    //                     $query->where('furnished', $data['furnished']);
    //                 });
    //             }
    //         }
    //         if (isset($data['minprice']) && isset($data['maxprice'])) {
    //             if ($data['minprice'] != '' && $data['maxprice'] != '') {
    //                 $property->whereHas('property_details', function ($query)  use ($data) {
    //                     $query->whereBetween('price', [$data['minprice'], $data['maxprice']]);
    //                 });
    //             }
    //         }


    //         //    if(isset($data['sort_type'])){
    //         //     if($data['sort_type'] == "HL"){
    //         //         $property->whereHas('property_details', function ($query)  use ($data) {
    //         //              $query->orderBy('price', 'DESC');
    //         //         });
    //         //     }

    //         //     if($data['sort_type'] == "LH"){
    //         //         $property->whereHas('property_details', function ($query)  use ($data) {
    //         //              $query->orderBy('price', 'ASC');
    //         //         });
    //         //     }
    //         //   }




    //         if (isset($data['vastu'])) {
    //             if ($data['vastu'] != '') {
    //                 $property->whereHas('vastu', function ($query)  use ($data) {
    //                     $query->where('vastu_id', $data['vastu']);
    //                 });
    //             }
    //         }
    //         if (isset($data['amenities'])) {
    //             $amenities = json_decode($data['amenities']);
    //             // echo gettype($amenities);
    //             // print_r($data['amenities']);
    //             // echo "netin";
    //             // exit;
    //             if (gettype($amenities) == 'array') {
    //                 if (count($amenities) > 0) {
    //                     $property->whereHas('amenities', function ($query)  use ($amenities) {
    //                         $query->whereIn('amenity_id', $amenities);
    //                     });
    //                 }
    //             }
    //         }
    //         if (isset($data['additional'])) {
    //             $additional = json_decode($data['additional']);
    //             if (gettype($additional) == 'array') {
    //                 if (count($additional) > 0) {
    //                     $property->whereHas('preferences', function ($query)  use ($additional) {
    //                         $query->whereIn('preference_id', $additional);
    //                     });
    //                 }
    //             }
    //         }
    //         if (isset($data['property_by'])) {
    //             if (strlen($data['property_by']) > 3) {
    //                 $userty = str_replace(array('[', ']'), '', $data['property_by']);
    //                 $usertypearray = explode(',', $userty);
    //                 if (gettype($usertypearray) == 'array') {
    //                     if (count($usertypearray) > 0) {
    //                         foreach ($usertypearray as $index => $value) {
    //                             $usertypearray[$index] = trim($value);
    //                         }
    //                         $property->join('users', 'users.id', '=', 'properties.user_id')
    //                             ->join('assigned_roles', 'assigned_roles.entity_id', '=', 'users.id')
    //                             ->join('roles', 'roles.id', '=', 'assigned_roles.role_id')
    //                             ->whereIn('roles.name', $usertypearray);
    //                     }
    //                 }
    //             }
    //         }


    //         $filter_userarray = ['lat' => isset($data['lat']) ? $data['lat'] : NULL, 'lng' => isset($data['lng']) ? $data['lng'] : NULL, 'type' => isset($data['type']) ? $data['type'] : NULL];
    //         $filterdata = UserFilter::firstOrNew(array('user_id' => $user->id));
    //         $filterdata->filter = serialize($filter_userarray);
    //         $filterdata->save();

    //         if (isset($data['sort_type'])) {
    //             if ($data['sort_type'] == "NEW") {
    //                 $property->orderBy("created_at", "desc");
    //             } elseif ($data['sort_type'] == "HL") {
    //                 $property->orderByRaw("(SELECT price FROM `property_details` where property_details.property_id=properties.id) DESC");
    //             } else {
    //                 $property->orderByRaw("(SELECT price FROM `property_details` where property_details.property_id=properties.id) ASC");
    //             }
    //         }


    //         $propertiey =  $property->get();
    //         //$dataarray=$propertiey->toArray();
    //         // $collection =collect($dataarray);

    //         // print_r($propertiey->toArray());
    //         return response()->json(['code' => '101', 'data' => $propertiey, 'status' => true]);
    //     } catch (Exception $e) {
    //         if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
    //             return response()->json(['success' => false, 'error' => 'Token is Invalid', 'code' => '102']);
    //         } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
    //             return response()->json(['success' => false, 'error' => 'Token is Expired', 'code' => '102']);
    //         } else {
    //             return response()->json(['success' => false, 'code' => '102', 'error' => $e]);
    //         }
    //     }
    // }

    public function nearbyproperties(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['code' => '103', 'error' => 'Invalid token', 'status' => false]);
            }
            $filterdata = UserFilter::where('user_id', $user->id)->first();
            if ($filterdata) {
                $filterval = unserialize($filterdata->filter);
                if ($filterval['lat'] != "" && $filterval['lng'] != "") {
                    $propert = Property::where('status', 1)->where('approved', 1)->with(['amenities.amenity_data', 'vastu.vastu_data', 'preferences.preferences_data', 'property_type.type_data', 'images', 'owner.roles' => function ($query) {
                        $query->select('name');
                    }, 'property_details'])->withCount([
                        'likes' => function ($query) use ($user) {
                            $query->where('user_id', $user->id);
                            $query->select(DB::raw('IF(count(*) > 0, 1, 0)'));
                        }
                    ]);
                    $radius = 30;


                    $propert->selectRaw("( 6371 * acos( cos( radians(?) ) * cos( radians( lat ) )* cos( radians( lng ) - radians(?)) + sin( radians(?) ) * sin( radians( lat ) ) )) AS distance", [$filterval['lat'], $filterval['lng'], $filterval['lat']])
                        ->having("distance", "<=", $radius)
                        ->orderBy("distance", 'asc');

                    // $propert->selectRaw("( 6371 * acos( cos( radians(?) ) * cos( radians( lat ) )* cos( radians( lng ) - radians(?)) + sin( radians(?) ) * sin( radians( lat ) ) )) AS distance", [$filterval['lat'], $filterval['lng'], $filterval['lat']])
                    // ->having("distance", "<=", $radius)
                    // ->orderBy("distance", 'asc');
                    $property = $propert->simplePaginate(10);
                } else {
                    $property = Property::with(['amenities.amenity_data', 'vastu.vastu_data', 'preferences.preferences_data', 'property_type.type_data', 'property_details', 'images', 'owner.roles' => function ($query) {
                        $query->select('name');
                    }])->withCount([
                        'likes' => function ($query) use ($user) {
                            $query->where('user_id', $user->id);
                            $query->select(DB::raw('IF(count(*) > 0, 1, 0)'));
                        }
                    ])->paginate(10);
                }
            }
            return response()->json(['code' => '101', 'data' => $property, 'status' => true]);
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['success' => false, 'error' => 'Token is Invalid', 'code' => '102']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['success' => false, 'error' => 'Token is Expired', 'code' => '102']);
            } else {
                return response()->json(['success' => false, 'code' => '102', 'error' => $e]);
            }
        }
    }


    public function gethotfeature(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['code' => '103', 'error' => 'Invalid token', 'status' => false]);
            }
            $data = $request->all();
            // echo "<pre>"; print_r($data);
            // exit;
            $properties_hot = Property::where('hot', 1)->where('approved', 1)->where('status', 1)->where('user_id', '!=', $user->id)->with(['amenities.amenity_data', 'vastu.vastu_data', 'preferences.preferences_data', 'owner.roles' => function ($query) {
                $query->select('name');
            }, 'property_type.type_data', 'property_details', 'images'])->withCount([
                'likes' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                    $query->select(DB::raw('IF(count(*) > 0, 1, 0)'));
                }
            ]);
            //  echo "<pre>"; print_r($properties_hot->toArray());
            // exit;
            $radius = 30;
            if (isset($data['lat']) && isset($data['lng'])) {                
                 $properties_hot->selectRaw("( 6371 * acos( cos( radians(?) ) * cos( radians( lat ) )* cos( radians( lng ) - radians(?)) + sin( radians(?) ) * sin( radians( lat ) ) )) AS distance", [$data['lat'], $data['lng'], $data['lat']]);
                
    
                // $lat = $data['lat'];
                // $lng = $data['lng'];

                // $haversine = "(6371 * acos(cos(radians($lat)) 
                //         * cos(radians(lat)) 
                //         * cos(radians(lng) 
                //         - radians($lng)) 
                //         + sin(radians($lat)) 
                //         * sin(radians(lat))))";

                // $properties_hot->selectRaw("{$haversine} AS distance")
                // ->whereRaw("{$haversine} < ?", [$radius])
                // ;

            }
            $hotproperty = $properties_hot->limit(10)->orderByDesc('created_at')->get();

            $properties_feature = Property::where('featured', 1)->where('status', 1)->where('approved', 1)->where('user_id', '!=', $user->id)->with(['amenities.amenity_data', 'vastu.vastu_data', 'preferences.preferences_data', 'owner.roles' => function ($query) {
                $query->select('name');
            }, 'property_type.type_data', 'property_details', 'images'])->withCount([
                'likes' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                    $query->select(DB::raw('IF(count(*) > 0, 1, 0)'));
                }
            ]);
            if (isset($data['lat']) && isset($data['lng'])) {
                $properties_feature->selectRaw("( 6371 * acos( cos( radians(?) ) * cos( radians( lat ) )* cos( radians( lng ) - radians(?)) + sin( radians(?) ) * sin( radians( lat ) ) )) AS distance", [$data['lat'], $data['lng'], $data['lat']]);
            }

            $featured_property = $properties_feature->limit(10)->orderByDesc('created_at')->get();

            $properties_all = Property::where('status', 1)->where('approved', 1)->where('user_id', '!=', $user->id)->with(['amenities.amenity_data', 'vastu.vastu_data', 'preferences.preferences_data', 'owner.roles' => function ($query) {
                $query->select('name');
            }, 'property_type.type_data', 'property_details', 'images'])->withCount([
                'likes' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                    $query->select(DB::raw('IF(count(*) > 0, 1, 0)'));
                }
            ]);
            if (isset($data['lat']) && isset($data['lng'])) {
                $properties_all->selectRaw("( 6371 * acos( cos( radians(?) ) * cos( radians( lat ) )* cos( radians( lng ) - radians(?)) + sin( radians(?) ) * sin( radians( lat ) ) )) AS distance", [$data['lat'], $data['lng'], $data['lat']]);
            }

            $all_property = $properties_all->limit(10)->orderByDesc('created_at')->get();



            return response()->json(['code' => '101', 'hot' => $hotproperty, 'featured' => $featured_property, 'all' => $all_property, 'status' => true]);
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['success' => false, 'error' => 'Token is Invalid', 'code' => '102']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['success' => false, 'error' => 'Token is Expired', 'code' => '102']);
            } else {
                return response()->json(['success' => false, 'code' => '102', 'error' => $e]);
            }
        }
    }
    public function propertylike(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['code' => '103', 'error' => 'Invalid token', 'status' => false]);
            }
            $user_id = $user->id;
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
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['success' => false, 'error' => 'Token is Invalid', 'code' => '102']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['success' => false, 'error' => 'Token is Expired', 'code' => '102']);
            } else {
                return response()->json(['success' => false, 'code' => '102', 'error' => $e]);
            }
        }
    }

    public function getlikedproperties(Request $request)
    {

        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['code' => '103', 'error' => 'user_not_found', 'status' => false]);
            }
            $properties = Property::with(['amenities.amenity_data', 'vastu.vastu_data', 'preferences.preferences_data', 'property_type.type_data', 'property_details', 'images', 'owner.roles' => function ($query) {
                $query->select('name');
            }])->whereHas('likes', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->withCount([
                'likes' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                    $query->select(DB::raw('IF(count(*) > 0, 1, 0)'));
                }
            ])->paginate(10);
            return response()->json(['code' => '101', 'response' => $properties, 'status' => true]);
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['success' => false, 'error' => 'Token is Invalid', 'code' => '102']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['success' => false, 'error' => 'Token is Expired', 'code' => '102']);
            } else {
                return response()->json(['success' => false, 'code' => '102', 'error' => $e]);
            }
        }
    }
}
