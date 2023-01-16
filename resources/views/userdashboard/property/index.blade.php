@extends('layouts.dashboard')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 dflx">
                    <h1 class="m-0">Property List</h1>
                    <div class="add_prpty cm-btn">
                        <a href="{{ route("frontuser.property.create") }}" class="db_btn"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Property</a>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12">
                    @foreach($properties as $property)
                    <div class="info-box">
                        <div class="proprty-strip dflx">
                            <div class="proprty-info">
                                <div class="proprty-view">
                                    @if(isset($property->images[0]))
                                    <a href="#"> <img src="{{$property->images[0]['url']}}" alt="image" height="147px" width="217px"></a>
                                    @endif

                                </div>
                                <div class="short-detail">
                                    <div class="prt-tag">
                                        <span class="badge rent-in">For {{$property->type}}</span>
                                    </div>
                                    <div class="proprty-name">
                                        <h4>{{$property->name}}</h4>
                                    </div>
                                    <div class="loc">
                                        <span><img src="{{ url('dashboard/images/location_blk.png')}}" alt="image"></span> {{$property->address}}
                                    </div>
                                    <div class="proprty-price">
                                        ₹ <span> @if(isset($property->property_details)) {{$property->property_details->price}} @endif</span>
                                    </div>
                                </div>
                            </div>
                            <div class="proprty-btns">
                                <div class="add_prpty cm-btn">
                                    @if($property->approved)
                                        <span class="badge badge-success">Approved</span>                                    
                                    @else
                                        <span class="badge badge-warning">Not approved</span>
                                    @endif
                                    <a href="{{ route('frontuser.property.show', $property->id) }}" class="db_btn"> View</a>                                    
                                    <a href="{{ route('frontuser.property.edit', $property->id) }}" class="db_btn edit_btn"> Edit</a>

                                    <a class="db_btn" href="{{ route('frontuser.property.image', $property->id) }}">
                                        Image
                                    </a>
                                    <a class="db_btn" href="{{ route('frontuser.property.leads', $property->id) }}">
                                        Leads
                                    </a>
                                    <a class="db_btn edit_btn" href="{{ route('frontuser.property.conversastion', $property->id) }}">
                                        {{ trans('cruds.property.fields.queries') }}
                                    </a>
                                
                            </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!-- ./wrapper -->
                    @endsection