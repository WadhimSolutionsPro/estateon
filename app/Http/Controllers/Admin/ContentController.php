<?php

namespace App\Http\Controllers\Admin;

use App\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateContentRequest;

class ContentController extends Controller
{
    /**
     * Display a listing of Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        

        $content = Content::all();
        //print '<pre>'; print_R($content); die;
        return view('admin.content.index', compact('content'));
    }

    /**
     * Show the form for creating new content.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        
        return view('admin.content.create');
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param  \App\Http\Requests\StoreRolesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContentsRequest $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $request->merge([
            'customer_name' => $request->name,
        ]);

        $content = Content::create($request->all());        

        return redirect()->route('admin.content.index');
    }


    /**
     * Show the form for editing content.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        //$abilities = Ability::get()->pluck('name', 'name');

        $content = Content::findOrFail($id);

        //return view('admin.content.edit', compact('content', 'abilities'));
        return view('admin.content.edit', compact('content'));
    }

    /**
     * Update Role in storage.
     *
     * @param  \App\Http\Requests\UpdateRolesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContentRequest $request, $id)
    {
        
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        
        
        $content = Content::findOrFail($id);

        $request->merge([
            'customer_name' => $request->name,
        ]);

        $content->update($request->all());

        return redirect()->route('admin.content.index');
    }

    // public function show(Role $role)
    // {
    //     if (! Gate::allows('users_manage')) {
    //         return abort(401);
    //     }

    //     $role->load('abilities');

    //     return view('admin.content.show', compact('role'));
    // }

    /**
     * Remove content from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $content = Content::findOrFail($id);
        $content->delete();

        return redirect()->route('admin.content.index');
    }

    /**
     * Delete all selected content at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        Content::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }

}
