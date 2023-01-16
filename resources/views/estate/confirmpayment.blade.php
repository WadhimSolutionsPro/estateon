@extends('layouts.estate')
@section('content')
<div class="align-items-center log-bg">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-lg-10 col-md-12 mx-auto">
                <div class="card login-card register-card">
                    <div class="card-body">
                        @if(count($errors) > 0 )
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <ul class="p-0 m-0" style="list-style: none;">
                                @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <h3 class="login-card-description text-center"> {{$plan->name}} pay {{$plan->price}}</h3>
                        <form action="{{ route("subscription.pay") }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <input type="text" name="name" id="name" class="form-control" value="{{$user->name}}" placeholder="Full Name" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    <div class="form-group mb-4">
                                        <input type="email" name="email" id="email" class="form-control" value="{{$user->email}}" placeholder="Email Address" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    <div class="form-group mb-4">
                                        <input type="tel" name="phone" id="phone_number" class="form-control" value="{{$user->phone}}" placeholder="Phone Number" required>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="plan_id" value="{{$plan->id}}">
                            <input name="payment" id="payment" class="btn btn-block login-btn mb-4" type="submit" value="Make Payment">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection