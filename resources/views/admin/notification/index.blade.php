@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.notification.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.notification.sendnotification") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="name">{{ trans('cruds.notification.fields.title') }}*</label>
                <input type="text" id="name" name="title" class="form-control" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <em class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.notification.fields.title_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                <label for="name">{{ trans('cruds.notification.fields.body') }}*</label>
                <input type="text" id="body" name="body" class="form-control" value="{{ old('body', '') }}" required>
                @if($errors->has('body'))
                    <em class="invalid-feedback">
                        {{ $errors->first('body') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.notification.fields.body_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('users') ? 'has-error' : '' }}">
                <label for="roles">{{ trans('cruds.user.title') }}*
                    <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                <select name="user[]" id="user" class="form-control select2" multiple="multiple" required>
                    @foreach($users as $id => $users)
                        <option value="{{ $users['id'] }}">{{ $users['name'] }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <em class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.roles_helper') }}
                </p>
            </div>


            <div>
                <input class="btn btn-danger" type="submit" value="Send">
            </div>
        </form>


    </div>
</div>
@endsection