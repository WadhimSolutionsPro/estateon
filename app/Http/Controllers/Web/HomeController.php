<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Property;
use App\PropertyType;
use App\Testimonials;
use App\User;
use App\Ui;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Silber\Bouncer\Database\Role;
use Illuminate\Support\Facades\Lang;
class HomeController extends Controller
{
    //
    public function index()
    {
        //print '<pre>'; print_r(Auth::guard('frontuser')->user()); die;
        $data['property_type'] = PropertyType::select(['id', 'name'])->get();
        $data['hot_featured'] = $this->gethotfeature();
        $data['by_admin'] = $this->getByAdmin();
        $data['by_users'] = $this->getByUsers();
        $data['section'] = Ui::Where('name','home')->with('uimeta.uimetadata')->get();
        // echo "<pre>"; print_r($data['section']->toArray());
        // exit;
        $data['testimonials'] = Testimonials::get();
        
        return view('estate.home', compact('data'));
    }

    public function gethotfeature()
    {
        $userId = "";
        if (Auth::check()) {
            $userId = Auth::id();
        }
        // echo "<pre>"; print_r($data);
        // exit;
        $properties_hot = Property::where('hot', 1)->where('approved', 1)->where('status', 1)->with(['amenities.amenity_data', 'vastu.vastu_data', 'preferences.preferences_data', 'owner.roles' => function ($query) {
            $query->select('name');
        }, 'property_type.type_data', 'property_details', 'images']);
        if ($userId != "") {
            $properties_hot->where('user_id', '!=', $userId)->withCount([
                'likes' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                    $query->select(DB::raw('IF(count(*) > 0, 1, 0)'));
                }
            ]);
        }
        $radius = 30;
        if (isset($data['lat']) && isset($data['lng'])) {
            $properties_hot->selectRaw("( 6371 * acos( cos( radians(?) ) * cos( radians( lat ) )* cos( radians( lng ) - radians(?)) + sin( radians(?) ) * sin( radians( lat ) ) )) AS distance", [$data['lat'], $data['lng'], $data['lat']]);
        }
        $hotproperty = $properties_hot->limit(10)->orderByDesc('created_at')->get();

        $properties_feature = Property::where('featured', 1)->where('status', 1)->where('approved', 1)->with(['amenities.amenity_data', 'vastu.vastu_data', 'preferences.preferences_data', 'owner.roles' => function ($query) {
            $query->select('name');
        }, 'property_type.type_data', 'property_details', 'images']);
        if ($userId != "") {
            $properties_feature->where('user_id', '!=', $userId)->withCount([
                'likes' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                    $query->select(DB::raw('IF(count(*) > 0, 1, 0)'));
                }
            ]);
        }
        $featured_property = $properties_feature->limit(10)->orderByDesc('created_at')->get();
        return ['code' => '101', 'hot' => $hotproperty, 'featured' => $featured_property, 'status' => true];
    }


    public function getByAdmin()
    {
        $userId = "";
        if (Auth::check()) {
            $userId = Auth::id();
        }
        // echo "<pre>"; print_r($data);
        // exit;
        $properties_hot = Property::where('created_by', 1)->where('approved', 1)->where('status', 1)->with(['amenities.amenity_data', 'vastu.vastu_data', 'preferences.preferences_data', 'owner.roles' => function ($query) {
            $query->select('name');
        }, 'property_type.type_data', 'property_details', 'images']);
        if ($userId != "") {
            $properties_hot->where('user_id', '!=', $userId)->withCount([
                'likes' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                    $query->select(DB::raw('IF(count(*) > 0, 1, 0)'));
                }
            ]);
        }
        $radius = 30;
        if (isset($data['lat']) && isset($data['lng'])) {
            $properties_hot->selectRaw("( 6371 * acos( cos( radians(?) ) * cos( radians( lat ) )* cos( radians( lng ) - radians(?)) + sin( radians(?) ) * sin( radians( lat ) ) )) AS distance", [$data['lat'], $data['lng'], $data['lat']]);
        }
        $hotproperty = $properties_hot->limit(10)->orderByDesc('created_at')->get();
        return $hotproperty;
    }

    public function getByUsers()
    {
        $userId = "";
        if (Auth::check()) {
            $userId = Auth::id();
        }
        // echo "<pre>"; print_r($data);
        // exit;
        $properties_hot = Property::where('created_by','!=', 1)->where('approved', 1)->where('status', 1)->with(['amenities.amenity_data', 'vastu.vastu_data', 'preferences.preferences_data', 'owner.roles' => function ($query) {
            $query->select('name');
        }, 'property_type.type_data', 'property_details', 'images']);
        if ($userId != "") {
            $properties_hot->where('user_id', '!=', $userId)->withCount([
                'likes' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                    $query->select(DB::raw('IF(count(*) > 0, 1, 0)'));
                }
            ]);
        }
        $radius = 30;
        if (isset($data['lat']) && isset($data['lng'])) {
            $properties_hot->selectRaw("( 6371 * acos( cos( radians(?) ) * cos( radians( lat ) )* cos( radians( lng ) - radians(?)) + sin( radians(?) ) * sin( radians( lat ) ) )) AS distance", [$data['lat'], $data['lng'], $data['lat']]);
        }
        $hotproperty = $properties_hot->limit(10)->orderByDesc('created_at')->get();
        return $hotproperty;
        
    }

    public function signin(){
        if($user = Auth::guard('frontuser')->user())
        {
            return redirect()->route('home.index');
        }else{ return view('estate.signin');}
       
    }
    public function signup(){
        if($user = Auth::guard('frontuser')->user())
{
    return redirect()->route('home.index');
}else{
    $data['roles'] = Role::whereNotIn('name', ['administrator','Deepak Murheker','assistant'])->get()->pluck('name', 'name');
    // echo "<pre>"; print_r($roles);
    // exit;
    return view('estate.signup', compact('data'));
}
    }
    public function postsignup(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'min:6|required_with:confirmpassword|same:confirmpassword',
            'confirmpassword' => 'min:6',
            'role' => 'required',
        ]);
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email') == "" ? NULL : $request->get('email'),
            'password' => $request->get('password') == "" ? NULL : Hash::make($request->get('password')),
            'phone' => $request->get('phone') == "" ? NULL : $request->get('phone')
        ]);
        $role=$request->get('role');
        if($role){
            $user->assign($role);
        }else{
            $user->assign('user');
        }
        return redirect()->route('home.signin');
        // echo "<pre>"; print_r($postdata);
        // exit;
    }
    public function postsignin(Request $request){
        $validated = $request->validate([
            'email' => 'required|email',
            //'password' => 'required|min:6',
        ]);
                if (Auth::guard('frontuser')->attempt(['email' => $request->email, 'password' => $request->password, 'user_level' => 0])) {
           $user=Auth::guard('frontuser')->user();
            if($user->isAdmin){
                return redirect()->intended(route('admin.home'));
            }else{
             return redirect()->route('home.index');
            }
    }else{
                return redirect()->back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => Lang::get('auth.failed'),
                ]);
            }
}
public function logout(Request $request) {
    Auth::guard('frontuser')->logout();
    return redirect('/');
  }
  public function invcaptcha()
  {
      return view('estate.phonesignin');
  }
}
