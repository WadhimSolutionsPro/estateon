<?php

namespace App\Http\Controllers\Admin;
use App\Vastu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
class VastuController extends Controller
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

        $vastu = Vastu::all();

        return view('admin.vastu.index', compact('vastu'));
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
        return view('admin.vastu.create');
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
        Vastu::create($request->all());

        return redirect()->route('admin.vastu.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Vastu $vastu)
    {
        //
         //
         if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        return view('admin.vastu.show', compact('vastu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Vastu $vastu)
    {

        //
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        // $ability = Ability::findOrFail($id);

        return view('admin.vastu.edit', compact('vastu'));
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
        $vastu = Vastu::findOrFail($id);
        $vastu->update($request->all());

        return redirect()->route('admin.vastu.index');
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
        $vastu = Vastu::findOrFail($id);
        $vastu->delete();

        return redirect()->route('admin.vastu.index');
    }
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        Vastu::whereIn('id', request('ids'))->delete();
        return response()->noContent();
    }
}
