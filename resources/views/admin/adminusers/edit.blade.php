@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.user.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.users.update", [$user->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- <div class="form-group {{ $errors->has('avatar') ? 'has-error' : '' }}">
                <label for="avatar">{{ trans('cruds.user.fields.avatar') }}</label>
                <input type="file" id="avatar" name="avatar" class="form-control">
                @if($errors->has('avatar'))
                <em class="invalid-feedback">
                    {{ $errors->first('avatar') }}
                </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.avatar_helper') }}
                </p>
            </div>
            @if($user->avatar !='')
            <div class="form-group {{ $errors->has('avatar') ? 'has-error' : '' }}">
                <input type="hidden" id="oldimage" name="oldimage" value="{{ old('image_url', isset($user) ? $user->avatar : '') }}" class="form-control">
                <img src="{{$user->avatar}}" alt="pro-img">
            </div>
            @endif -->
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('cruds.user.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($user) ? $user->name : '') }}" required>
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">{{ trans('cruds.user.fields.email') }}*</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', isset($user) ? $user->email : '') }}" required>
                @if($errors->has('email'))
                    <em class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.email_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label for="password">{{ trans('cruds.user.fields.password') }}</label>
                <input type="password" id="password" name="password" class="form-control">
                @if($errors->has('password'))
                    <em class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.password_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('detail') ? 'has-error' : '' }}">
                <label for="detail">{{ trans('cruds.user.fields.detail') }}</label>
                <textarea id="detail" name="detail" class="form-control" >{{ old('detail', isset($user) ? $user->detail : '') }}</textarea>
                @if($errors->has('detail'))
                    <em class="invalid-feedback">
                        {{ $errors->first('detail') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.detail_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                <label for="phone">{{ trans('cruds.user.fields.phone') }}</label>
                <input type="tel" id="phonenumber" name="phone" class="form-control" placeholder="+912134567890" pattern="^(\+91[\-\s]?)?[0]?(91)?[789]\d{9}$" value="{{ old('phone', isset($user) ? $user->phone : '') }}">
                @if($errors->has('phone'))
                    <em class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.password_helper') }}
                </p>
            </div>
            
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection