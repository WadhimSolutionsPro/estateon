<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Silber\Bouncer\Database\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use App\commonfunction;
class UsersController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        $filter = [];
        $filter_all = isset($_GET['q']) ? $_GET['q'] : '';

        if ($filter_all != '') {
            $users = User::with(['roles'])->where('name', 'LIKE', '%' . $filter_all . '%')
                ->orWhere('email', 'LIKE', '%' . $filter_all . '%')
                ->orWhere('phone', 'LIKE', '%' . $filter_all . '%')
                ->orderBy('id', 'desc');
            $filter['q'] = $filter_all;
        } else {
            $users = User::with(['roles'])->orderBy('id', 'desc');
        }
        $users = $users->paginate(15);
        return view('admin.users.index', ['users' => $users, 'filter' => $filter]);
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        $roles = Role::get()->pluck('name', 'name');

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersRequest $request)
    {        
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        $data = $request->all();
        //Phone Number Formatting//
        $re = '/^(?:\+?91|0)?/m';
        $phone = $request->input('phone');
        $ccode = '+91';
        $result = preg_replace($re, $ccode, $phone);
        $data['phone'] = $result;
        

        if (in_array("administrator", $data['roles']) && count($data['roles']) == 1)
        {
            $data['user_level'] = 2;
        }
        ///
        $data['slug']=commonfunction::createSlug($data['name'],0,'user');
        //echo "<pre>"; print_r($data); die;
        // exit;
        $user = User::create($data);

        foreach ($request->input('roles') as $role) {
            $user->assign($role);
        }

        if($data['user_level'] == 2){
            return redirect()->route('admin.adminusers.index');    
        }else{
            return redirect()->route('admin.users.index');
        }
        
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        $roles = Role::get()->pluck('name', 'name');

        $user = User::findOrFail($id);
// echo "<pre>"; 
// print_r($user->toArray());
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsersRequest $request, $id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        $user = User::findOrFail($id);
        $data = $request->all();
        //Phone Number Formatting//
        $re = '/^(?:\+?91|0)?/m';
        $phone = $request->input('phone');
        $ccode = '+91';
        $result = preg_replace($re, $ccode, $phone);
        $data['phone'] = $result;
        ///

        if ($request->hasFile('avatar')) {
           
            $file = $request->file('avatar');
            $actualfilename = $file->getClientOriginalName();
            $extension = $file->extension();
            $filename = time().".".$extension;
            $path = public_path() . '/uploads/image/user' . $id . '/';
            if(isset($data['oldimage'])){
                $oldfile=basename($data['oldimage']);
                unlink($path.$oldfile);
            }
            
            $file->move($path, $filename);
            $url = url('/uploads/image/user' . $id . '/' . $filename);
            $data['avatar']=$url;         
        }


        ////
        $user->update($data);
        foreach ($user->roles as $role) {
            $user->retract($role);
        }
        foreach ($request->input('roles') as $role) {
            $user->assign($role);
        }

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index');
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        User::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }
}
