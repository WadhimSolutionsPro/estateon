@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Edit Page Content
    </div>

    <div class="card-body">
        <form action="{{ route("admin.content.update", [$content->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Page Name*</label>
                <p type="text" id="name" class="form-control">
                {{ucfirst($content->page_key)}}
                </p>
            </div>


            <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                <label for="my-editor">Page Content*</label>
                <textarea id="my-editor" name="content" class="form-control" required>{{ old('content', isset($content) ? $content->content : '') }}</textarea>
                @if($errors->has('content'))
                    <em class="invalid-feedback">
                        {{ $errors->first('content') }}
                    </em>
                @endif
            </div>               


            
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.0.1/ckeditor.js"></script>

<script>
    window.onload = function(e){ 
        if($('#my-editor').length>0){
            CKEDITOR.replace('my-editor');
            CKEDITOR.config.removeButtons = 'Image'; 
        }
    }
</script>

@endsection
