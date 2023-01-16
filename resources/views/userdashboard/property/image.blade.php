@extends('layouts.dashboard')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 dflx">
                    <h1 class="m-0">Images</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="add_pprty space">
        <div class="container-fluid">
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12 upl-image-area">
                    <form action="{{ route('frontuser.property.addimage') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                        <label for="myfile"><strong>Add image:</strong></label>
                        <input type="file" id="image" name="image" class="choose-img">
                        @if($errors->has('image'))
                            <em class="invalid-feedback">
                                {{ $errors->first('image') }}
                            </em>
                            @endif
                        <input type="hidden" name="property_id" value="{{$data['property_id']}}">
                        <input type="submit" class="btn btn-info">
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
                                <a href="{{route('frontuser.property.deleteimage', $image->id)}}" class="btn btn-tool" data-card-widget="remove1"><i class="fa fa-times"></i>
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
        </div>
    </section>
    </div>

@endsection
