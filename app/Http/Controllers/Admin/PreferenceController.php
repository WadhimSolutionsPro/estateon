<?php

namespace App\Http\Controllers\Admin;
use App\Preferences;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PreferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
             //
             if (!Gate::allows('users_manage')) {
                return abort(401);
            }    
            $preference = Preferences::all();    
            return view('admin.preference.index', compact('preference'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
           //
           if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        return view('admin.preference.create');
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
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
        Preferences::create($request->all());

        return redirect()->route('admin.preference.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Preferences $preference)
    {
        //
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        return view('admin.preference.show', compact('preference'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Preferences $preference)
    {
        //
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        // $ability = Ability::findOrFail($id);

        return view('admin.preference.edit', compact('preference'));
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
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        $preference = Preferences::findOrFail($id);
        $preference->update($request->all());

        return redirect()->route('admin.preference.index');
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
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        $preference = Preferences::findOrFail($id);
        $preference->delete();

        return redirect()->route('admin.preference.index');
    }
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        Preferences::whereIn('id', request('ids'))->delete();
        return response()->noContent();
    }
}
