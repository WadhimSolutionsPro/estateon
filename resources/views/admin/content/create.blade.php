@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Edit Testimonial
    </div>

    <div class="card-body">
        <form action="{{ route("admin.testimonials.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">Customer Name*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($testimonial) ? $testimonial->customer_name : '') }}" required>
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.role.fields.name_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('customer_designation') ? 'has-error' : '' }}">
                <label for="name">Customer Designation*</label>
                <input type="text" id="name" name="customer_designation" class="form-control" value="{{ old('customer_designation', isset($testimonial) ? $testimonial->customer_designation : '') }}" required>
                @if($errors->has('customer_designation'))
                    <em class="invalid-feedback">
                        {{ $errors->first('customer_designation') }}
                    </em>
                @endif
            </div>

            <div class="form-group {{ $errors->has('testimonial') ? 'has-error' : '' }}">
                <label for="name">Testimonial*</label>
                <textarea id="testimonial" name="testimonial" class="form-control" required>{{ old('testimonial', isset($testimonial) ? $testimonial->testimonial : '') }}</textarea>
                @if($errors->has('testimonial'))
                    <em class="invalid-feedback">
                        {{ $errors->first('testimonial') }}
                    </em>
                @endif
            </div>
                


            <div class="form-group {{ $errors->has('rating') ? 'has-error' : '' }}">
                <label for="name">Rating*</label>
                <select name="rating" id="rating" class="form-control select21" required>
                    <option value="1" {{ (isset($testimonial) && $testimonial->rating==1) ? 'selected' : '' }}>1</option>                    
                    <option value="2" {{ (isset($testimonial) && $testimonial->rating==2) ? 'selected' : '' }}>2</option>
                    <option value="3" {{ (isset($testimonial) && $testimonial->rating==3) ? 'selected' : '' }}>3</option>
                    <option value="4" {{ (isset($testimonial) && $testimonial->rating==4) ? 'selected' : '' }}>4</option>
                    <option value="5" {{ (isset($testimonial) && $testimonial->rating==5) ? 'selected' : '' }}>5</option>
                </select>
                @if($errors->has('rating'))
                    <em class="invalid-feedback">
                        {{ $errors->first('rating') }}
                    </em>
                @endif
            </div>

            <div class="form-group {{ $errors->has('publish') ? 'has-error' : '' }}">
                <label for="name">Publish*</label>
                <select name="publish" id="publish" class="form-control select21" required>
                    <option value="1" {{ (isset($testimonial) && $testimonial->publish==1) ? 'selected' : '' }}>Publish</option>                    
                    <option value="0" {{ (isset($testimonial) && $testimonial->publish==0) ? 'selected' : '' }}>Un Publish</option>
                </select>
                @if($errors->has('publish'))
                    <em class="invalid-feedback">
                        {{ $errors->first('publish') }}
                    </em>
                @endif
            </div>
            
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection
