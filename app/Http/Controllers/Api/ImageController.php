<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use JWTAuth;
use Auth;
use Exception;

class ImageController extends Controller
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
    public function create(Request $request)
    {
        //
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['code' => '103', 'error' => 'user_not_found', 'status' => false]);
            }
            $data = $request->all();
            $property_id = $data['property_id'];
            //get the base-64 from data
            $url = false;
            $image_id = array();
            $urls=array();
      if($filesdata=$request->file('image')){
                foreach($filesdata as $file){
                   
                        $filename=$file->getClientOriginalName();
                        $path = public_path() . '/uploads/image/property' . $property_id . '/';
                        $file->move($path, $filename);
                        $images[]=$filename;
                        $url = url('/uploads/image/property' . $property_id . '/' . $filename);
                        $urls[]=$url;
                        $image = Images::create([
                            'property_id' => $property_id,
                            'name' => $filename,
                            'url' => $url,
                            'featured' => 0
                        ]);
                         $image_id[] =$image->id;
                   
                }
            }


            // if ($request->hasFile('image')) {
            //     $file = $request->file('image');
            //     $filename = $file->getClientOriginalName();
            //     $path = public_path() . '/uploads/image/property' . $property_id . '/';
            //     $file->move($path, $filename);
            //     $url = url('/uploads/image/property' . $property_id . '/' . $filename);
            //     $image = Images::create([
            //         'property_id' => $property_id,
            //         'name' => $filename,
            //         'url' => $url,
            //         'featured' => 0
            //     ]);
            //     $image_id = $image->id;
            // }

            return response()->json(['code' => '101', 'urls' => $urls, 'ids' => $image_id, 'status' => true]);
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


    public function addimg(Request $request)
    {
        //
        try { 
            $data = $request->all();
            $property_id = $data['property_id'];
            //get the base-64 from data
            $url = false;
            $image_id = array();
            $urls=array();
            
            if($filesdata=$request->file('image')){
                foreach($filesdata as $file){
                   
                        $filename=$file->getClientOriginalName();
                        $path = public_path() . '/uploads/image/property' . $property_id . '/';
                        $file->move($path, $filename);
                        $images[]=$filename;
                        $url = url('/uploads/image/property' . $property_id . '/' . $filename);
                        $urls[]=$url;
                        $image = Images::create([
                            'property_id' => $property_id,
                            'name' => $filename,
                            'url' => $url,
                            'featured' => 0
                        ]);
                         $image_id[] =$image->id;
                   
                }
            }
            return response()->json(['code' => '101', 'urls' => $urls, 'ids' => $image_id, 'status' => true]);
        }catch (Exception $e) {
            return response()->json(['success' => false, 'code' => '102']);
        }
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
     * @param  \App\Images  $images
     * @return \Illuminate\Http\Response
     */
    public function show(Images $images)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Images  $images
     * @return \Illuminate\Http\Response
     */
    public function edit(Images $images)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Images  $images
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Images $images)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Images  $images
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['code' => '103', 'error' => 'user_not_found', 'status' => false]);
            }
            $data = $request->all();
            $image_id = $data['image_id'];
            $image = Images::where('id', $image_id)->first();
            if ($image) {
                $image_path = '/uploads/image/property' . $image->property_id . '/' . $image->name;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
                $image = Images::where('id', $image_id)->delete();
            }
            return response()->json(['code' => '101', 'status' => true]);
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
    public function featuredimage(Request $request){
try{
    if (!$user = JWTAuth::parseToken()->authenticate()) {
        return response()->json(['code' => '103', 'error' => 'user_not_found', 'status' => false]);
    }
    $data = $request->all();
    $image_id = $data['image_id'];
    $property_id= $data['property_id'];
    $unfeatured = Images::where('property_id', $property_id)
              ->update(['featured' => 0]);
              if($unfeatured){
                  $featured=Images::where('id', $image_id)
                  ->update(['featured' => 1]);
                  if($featured){
                    return response()->json(['code' => '101', 'status' => true]);  
                  }else{
                    return response()->json(['status' => false, 'code' => '102']);
                  }
              }else{
                return response()->json(['status' => false, 'code' => '102']);
              }

}catch(Exception $e){
    if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
        return response()->json(['success' => false, 'error' => 'Token is Invalid', 'code' => '102']);
    } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
        return response()->json(['success' => false, 'error' => 'Token is Expired', 'code' => '102']);
    } else {
        return response()->json(['success' => false, 'code' => '102']);
    }
}
    }
}
