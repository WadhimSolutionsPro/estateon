@extends('layouts.admin')
@section('content')
<link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
<div class="content">
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$data['user']}}</h3>
                    <p>Users</p>
                </div>
                <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$data['rent']}}</h3>
                    <p>Rent Properties</p>
                </div>
                <div class="icon">
                <i class="ion ion-home"></i>
              </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$data['sale']}}</h3>
                    <p>Sale Properties</p>
                </div>
                <div class="icon">
                <i class="far fa-building"></i>
              </div>
            </div>
        </div>
        <!-- ./col -->
    </div>
</div>
@endsection
@section('scripts')
@parent

@endsection