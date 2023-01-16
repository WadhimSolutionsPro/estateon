<?php

namespace App\Http\Controllers\Admin;

use App\Testimonials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTestimonialsRequest;
use App\Http\Requests\Admin\UpdateTestimonialsRequest;

class TestimonialsController extends Controller
{
    /**
     * Display a listing of Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        

        $testimonials = Testimonials::all();
        //print '<pre>'; print_R($testimonials); die;
        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating new testimonial.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param  \App\Http\Requests\StoreRolesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTestimonialsRequest $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $request->merge([
            'customer_name' => $request->name,
        ]);

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        $data = $request->all();

        $testimonial = Testimonials::create($request->all());

        if ($request->hasFile('image')) {
            //print 'a'; die;
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $path = public_path() . '/uploads/testimonials' . $testimonial->id . '/';
            $file->move($path, $filename);
            $url = url('/uploads/testimonials' . $testimonial->id . '/' . $filename);
            //print $url; die;         
            $image = Testimonials::where('id',$testimonial->id)->update([
                'image' => $url
            ]);
        }

        return redirect()->route('admin.testimonials.index');
    }


    /**
     * Show the form for editing testimonial.
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

        $testimonial = Testimonials::findOrFail($id);

        //return view('admin.testimonials.edit', compact('testimonial', 'abilities'));
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update Role in storage.
     *
     * @param  \App\Http\Requests\UpdateRolesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTestimonialsRequest $request, $id)
    {
        
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        
        
        $testimonial = Testimonials::findOrFail($id);

        $request->merge([
            'customer_name' => $request->name,
        ]);

        $testimonial->update($request->all());

        if ($request->hasFile('image')) {
            //print 'a'; die;
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $path = public_path() . '/uploads/testimonials' . $testimonial->id . '/';
            $file->move($path, $filename);
            $url = url('/uploads/testimonials' . $testimonial->id . '/' . $filename);
            //print $url; die;         
            $image = Testimonials::where('id',$testimonial->id)->update([
                'image' => $url
            ]);
        }

        return redirect()->route('admin.testimonials.index');
    }

    // public function show(Role $role)
    // {
    //     if (! Gate::allows('users_manage')) {
    //         return abort(401);
    //     }

    //     $role->load('abilities');

    //     return view('admin.testimonials.show', compact('role'));
    // }

    /**
     * Remove testimonial from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $testimonial = Testimonials::findOrFail($id);
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index');
    }

    /**
     * Delete all selected testimonials at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        Testimonials::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }

}
