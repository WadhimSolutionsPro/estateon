@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12 upl-image-area">
        <form action="{{ route('admin.property.addimage') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
            <label for="myfile"><strong>Add image:</strong></label>
            <input type="file" id="image" name="image" class="choose-img">
            @if($errors->has('image'))
                <em class="invalid-feedback">
                    {{ $errors->first('image') }}
                </em>
                @endif
            <input type="hidden" name="property_id" value="{{$data['property_id']}}">
            <input type="submit" class="btn btn-default">
        </form>
    </div>
</div>
<div class="row">
    @foreach($data['images'] as $image)
    <div class="col-xl-3 col-lg-3">
        <!-- Box Comment -->
        <div class="card card-widget img-box"> 
            <div class="card-header">
                <div class="card-tools">
                    <a href="{{route('admin.property.deleteimage', $image->id)}}" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <a href="{{$image->url}}" data-lightbox="photos">
    <img class="img-fluid pad" src="{{$image->url}}" alt="{{$image->name}}">
  </a>
            </div>
            <!-- /.card-body -->
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>
    @endforeach
</div>

@endsection
