<?php

namespace App\Http\Controllers\Api;

use App\Vastu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Auth;

class VastuController extends Controller
{
    //
    public function index()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['code' => '103', 'error' => 'Invalid token', 'status' => false]);
            }
            $vastu = Vastu::get();
            return response()->json(['code' => '101', 'data' => $vastu, 'status' => true]);
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
}
