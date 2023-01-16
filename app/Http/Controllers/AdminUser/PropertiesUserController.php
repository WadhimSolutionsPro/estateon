<?php

namespace App\Http\Controllers\AdminUser;

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
use App\Images;
use App\Likes;
use App\commonfunction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use phpDocumentor\Reflection\Types\Null_;
use App\Http\Requests\Admin\UpdatepropertyRequest;

class PropertiesUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(Auth::user()->user_level != 2){
            return abort(401);
        }
        // if (!Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        $filter = [];
        $filtertype=[];
        $property_type=[];
        $filter_all = isset($_GET['q']) ? $_GET['q'] : '';

        $userID=Auth::user()->id;

        $property = Property::with(['amenities.amenity_data', 'vastu.vastu_data', 'preferences.preferences_data', 'property_type.type_data', 'property_details']);
        if ($filter_all != '') {
            $filtertype = isset($_GET['filter_type']) ? $_GET['filter_type'] : $filtertype;
            $property_type = isset($_GET['pr_type']) ? $_GET['pr_type'] : $property_type;
            if (is_array($property_type)) {
                if (in_array("rent", $property_type)) {
                    $property->where('type', 'rent');
                }
                if (in_array("sale", $property_type)) {
                    $property->where('type', 'sale');
                }
            }
            if (is_array($filtertype)) {
                if (in_array("amenities", $filtertype)) {
                    $property->whereHas('amenities.amenity_data', function ($query) use ($filter_all) {
                        $query->where('name', 'like', '%'.$filter_all.'%');
                    });
                }
                if (in_array("vastu", $filtertype)) {
                    $property->whereHas('vastu.vastu_data', function ($query) use ($filter_all) {
                        $query->where('name', 'like', '%'.$filter_all.'%');
                    });
                }
                if (in_array("property_type", $filtertype)) {
                    $property->whereHas('property_type.type_data', function ($query) use ($filter_all) {
                        $query->where('name', 'like', '%'.$filter_all.'%');
                    });
                }
            }
            $filter['q'] = $filter_all;
        }
        $property->orderBy('id', 'desc');
        $property->where('created_by', $userID);
        $properties = $property->paginate(10);
        // echo "<pre>"; print_r($properties->toArray()); echo "<pre>";
        // exit;
        return view('adminuser.property.index', compact('properties', 'filter', 'filtertype','property_type' ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(Auth::user()->user_level != 2){
            return abort(401);
        }
        // if (!Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        $data = [];
        $data['property_type'] = PropertyType::get();
        $data['vastu'] = Vastu::get();
        $data['amenity'] = Amenity::get();
        $data['preferences'] = Preferences::get();

        return view('adminuser.property.create', compact('data'));
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
        $data = $request->all();
        //echo "<pre>"; print_r($data); echo "</pre>"; die;
        // exit;
        $user_id = Auth::user()->id;
        //print $user_id; die;
        $property = Property::create([
            'name' => $data['name'],
            'user_id' => $user_id,
            'description' => isset($data['description']) ? $data['description'] : '',
            'address' => isset($data['address']) ? $data['address'] : '',
            'lat' => $data['lat'],
            'lng' => $data['lng'],
            'type' => $data['type'],
            'status' => 1,
            'featured' => isset($data['featured']) ? 1 : 0,
            'hot' => isset($data['hot']) ? 1 : 0,
            //'notes' => $data['notes'],
            'slug'=> commonfunction::createSlug($data['name'],0,'property'),
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
        //$additional =  isset($data['additional']) ?  json_decode($data['additional']) : [];
        $additional =  isset($data['additional']) ?  $data['additional'] : [];
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

        ////property details
        // $property_details = Propertydetail::create([
        //     'property_id' => $property_id,
        //     'bedroom' => $data['bedroom'],
        //     'bathroom' => $data['bathroom'],
        //     'balcony' => $data['balcony'],
        //     'kitchen' => $data['kitchen'],
        //     'living_room' => isset($data['living_room']) ? 1 : 0,
        //     'furnished' => $data['furnished'],
        //     'price' => $data['price'],
        //     'currency' => isset($data['currency']) ? $data['currency'] : NULL,
        // ]);

        $extraNotes = isset($data['extra_notes']) ? $data['extra_notes'] : '';

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

        if(Auth::user()->user_level == 1){
            return redirect()->route('admin.property.index');
        }else if(Auth::user()->user_level == 2){
            return redirect()->route('adminuser.property.index');
        }else {
            return redirect()->route('userproperties.index');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->user_level != 2){
            return abort(401);
        }
        //
        // if (!Gate::allows('users_manage')) {
        //     return abort(401);
        // }

        $data = [];
        $data['property'] = Property::where('id', $id)->withCount('likes')->with(['amenities.amenity_data', 'vastu.vastu_data', 'preferences.preferences_data', 'property_type.type_data', 'property_details'])->first();
        return view('adminuser.property.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->user_level != 2){
            return abort(401);
        }
        //
        // if (!Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        $data = [];
        $data['property_type'] = PropertyType::get();
        $data['vastu'] = Vastu::get();
        $data['amenity'] = Amenity::get();
        $data['preferences'] = Preferences::get();
        $data['property'] = Property::where('id', $id)->with(['amenities.amenity_data', 'vastu.vastu_data', 'preferences.preferences_data', 'property_type.type_data', 'property_details'])->first();
        return view('adminuser.property.edit', compact('data'));
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
        $data = $request->all();
        // echo "<pre>"; print_r($data);
        // exit;

        $user_id = Auth::user()->id;

        $update_property = [
            'name' => $data['name'],
            'user_id' => $user_id,
            'description' => isset($data['description']) ? $data['description'] : '',
            'address' => isset($data['address']) ? $data['address'] : '',
            'lat' => $data['lat'],
            'lng' => $data['lng'],
            'type' => $data['type'],
            'status' => 1,
            'featured' => isset($data['featured']) ? 1 : 0,
            'hot' => isset($data['hot']) ? 1 : 0,
            //'notes' => $data['notes'],
            'slug'=> commonfunction::createSlug($data['name'],0,'property'),
            'created_by' => $user_id
        ];
        Property::where('id', $id)
            ->update($update_property);

        ///Vastu///
        $vastu = isset($data['vastu']) ? $data['vastu'] : "";
        $assigned_vastu = AssignedVastu::where('property_id', $id)->delete();
        if ($vastu != "") {
            $assign_vastu = AssignedVastu::create([
                'vastu_id' => $vastu,
                'property_id' => $id
            ]);
        }
        ///property type
        $property_type = $data['property_type'];
        $assigned_types = AssignedTypes::where('property_id', $id)->delete();
        if ($property_type != '') {
            $assign_type = AssignedTypes::create([
                'type_id' => $property_type,
                'property_id' => $id
            ]);
        }
        ////Amenities
        $amenities = $data['amenities'];
        $assigned_amenities = AssignedAmenities::where('property_id', $id)->delete();
        if (gettype($amenities) == 'array') {
            $insert_ammenity = [];
            if (count($amenities) > 0) {
                foreach ($amenities as $value) {
                    $values = [];
                    $values['amenity_id'] = $value;
                    $values['property_id'] = $id;
                    $values["created_at"] = Carbon::now();
                    $values["updated_at"] = now();
                    array_push($insert_ammenity, $values);
                }
                AssignedAmenities::insert($insert_ammenity);
            }
        }
        ///Additional
        $additional =  isset($data['additional']) ? $data['additional'] : [];
        $assigned_additional = AssignedPreferences::where('property_id', $id)->delete();
        if (gettype($additional) == 'array') {
            $insert_additional = [];
            if (count($additional) > 0) {
                foreach ($additional as $value) {
                    $values = [];
                    $values['preference_id'] = $value;
                    $values['property_id'] = $id;
                    $values["created_at"] = Carbon::now();
                    $values["updated_at"] = now();
                    array_push($insert_additional, $values);
                }
                AssignedPreferences::insert($insert_additional);
            }
        }

        $extraNotes = isset($data['extra_notes']) ? $data['extra_notes'] : '';

        $update_details = [            
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
        ];
        Propertydetail::where('property_id', $id)
            ->update($update_details);

            if(Auth::user()->user_level == 1){
                return redirect()->route('admin.property.index');
            }else if(Auth::user()->user_level == 2){
                return redirect()->route('adminuser.property.index');
            }else {
                return redirect()->route('userproperties.index');
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->user_level != 2){
            return abort(401);
        }
        //
        // if (!Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        $property = Property::findOrFail($id);
        $property->delete();

        return redirect()->route('adminuser.property.index');
    }

    public function image($id)
    {
        $data['images'] = Images::where('property_id', $id)->get();
        $data['property_id'] = $id;
        return view('adminuser.property.image', compact('data'));
        // exit;
    }
    public function addimage(Request $request)
    {
        if(Auth::user()->user_level != 2){
            return abort(401);
        }
        // if (!Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $path = public_path() . '/uploads/image/property' . $data['property_id'] . '/';
            $file->move($path, $filename);
            $url = url('/uploads/image/property' . $data['property_id'] . '/' . $filename);
            $image = Images::create([
                'property_id' => $data['property_id'],
                'name' => $filename,
                'url' => $url,
                'featured' => 0
            ]);
            $image_id = $image->id;
        }
        return redirect()->route('adminuser.property.image', $data['property_id']);
    }
    public function deleteimage($id)
    {
        if(Auth::user()->user_level != 2){
            return abort(401);
        }
        //
        // if (!Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        $image = Images::findOrFail($id);
        $image->delete();

        return redirect()->route('adminuser.property.image', $image->property_id);
    }
    public function changestatus($id, $status){
        $condition=[];
        switch($status){
            case 'approve': 
                $condition['approved']=1;
            break;
            case 'activate': 
                $condition['status']=1;
            break;
            case 'deactivate': 
                $condition['status']=0;
            break;            
        }
        if(count($condition)>0){
            Property::where('id', $id)->update($condition);
        }
        return redirect()->back();
    }
}
