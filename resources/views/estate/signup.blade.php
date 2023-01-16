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
            <h3 class="login-card-description text-center">Sign up your account</h3>
            <form action="{{ route("home.postsignup") }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-md-12 col-lg-6">
                  <div class="form-group">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Full Name">
                  </div>
                </div>
                <div class="col-md-12 col-lg-6">
                  <div class="form-group mb-4">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email Address">
                  </div>
                </div>
                <div class="col-md-12 col-lg-6">
                  <div class="form-group mb-4">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                  </div>
                </div>
                <div class="col-md-12 col-lg-6">
                  <div class="form-group mb-4">
                    <input type="password" name="confirmpassword" id="password" class="form-control" placeholder="Confirm Password">
                  </div>
                </div>
                <div class="col-md-12 col-lg-6">
                  <div class="form-group mb-4">
                    <input type="tel" name="phone" id="phone_number" class="form-control" placeholder="Phone Number">
                  </div>
                </div>
                <div class="col-md-12 col-lg-6">
                  <div class="form-group mb-4">
                    <select class="form-control" id="role" name="role">
                      <option value="">Select Role</option>
                      @foreach($data['roles'] as $role)
                      <option value="{{$role}}">{{$role}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            <input name="signup" id="signup" class="btn btn-block login-btn mb-4" type="submit" value="Sign Up">
            </form>
            <div class="text-center">
              <p class="login-card-footer-text">Already Have An Account? <a href="{{ route("home.signin") }}" class="web-clr">Go For Log In</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection