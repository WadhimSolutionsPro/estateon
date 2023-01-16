<?php

namespace App\Http\Controllers\Admin;

use App\PropertyType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PropertytypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        $propertytype = PropertyType::all();

        return view('admin.propertytype.index', compact('propertytype'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        return view('admin.propertytype.create');
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
        PropertyType::create($request->all());

        return redirect()->route('admin.propertytype.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PropertyType $propertytype)
    {
        //
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        return view('admin.propertytype.show', compact('propertytype'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PropertyType $propertytype)
    {
        //
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        // $ability = Ability::findOrFail($id);

        return view('admin.propertytype.edit', compact('propertytype'));
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
        $propertytype = PropertyType::findOrFail($id);
        $propertytype->update($request->all());
        return redirect()->route('admin.propertytype.index');
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
        $propertytype = PropertyType::findOrFail($id);
        $propertytype->delete();

        return redirect()->route('admin.propertytype.index');
    }
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        PropertyType::whereIn('id', request('ids'))->delete();
        return response()->noContent();
    }
}
