@extends('layouts.estate')
@section('content')
<div class="align-items-center log-bg">
  <div class="container">
    <div class="row no-gutters">
      <div class="col-lg-9 col-md-10 mx-auto">
        <div class="card login-card">
          <div class="card-body">
            <h3 class="login-card-description text-center">Sign into your account</h3>
            <!-- <ul class="nav nav-pills mb-2" id="pills-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-email" role="tab" aria-controls="pills-home" aria-selected="true">Email</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-phone" role="tab" aria-controls="pills-profile" aria-selected="false">Phone</a>
              </li>
            </ul> -->
            <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane fade show active" id="pills-email" role="tabpanel" aria-labelledby="pills-home-tab">
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
                <form action="{{ route("home.postsignin") }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label for="email" class="sr-only">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email address">
                  </div>
                  <div class="form-group mb-4">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                  </div>
                  <input name="login" id="login" class="btn btn-block login-btn mb-4" type="submit" value="Login">
                </form>
                <div class="text-center">
                  <a href="{{route("forget.password.get")}}" class="forgot-password-link">Forgot password?</a>
                  <p class="login-card-footer-text">Don't have an account? <a href="{{route("home.signup")}}" class="web-clr">Register here</a></p>
 
                </div>
              </div>
              <!-- <div class="tab-pane fade" id="pills-phone" role="tabpanel" aria-labelledby="pills-profile-tab">
                <form id="sign-in-form" action="#">
                  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" pattern="\+[0-9\s\-\(\)]+" id="phone-number">
                    <label class="mdl-textfield__label" for="phone-number">
                      Enter your Mobile number..</label>
                    <span class="mdl-textfield__error">Input is not an international M number!</span>
                  </div>

                  <button class="btn btn-primary" id="sign-in-button">Sign-in</button>
                </form>

                <form id="verification-code-form" action="#">
                  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" id="verification-code">
                    <label class="mdl-textfield__label" for="verification-code">
                      Enter the verification code...</label>
                  </div>
                  <input type="submit" class="btn btn-success" id="verify-code-button" value="Verify Code" />
                  <button class="btn btn-danger" id="cancel-verify-code-button">Cancel</button>
                </form>

              </div> -->
            </div>









          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')


<script src="https://www.gstatic.com/firebasejs/8.2.7/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.2.7/firebase-auth.js"></script>
<script>
  var firebaseConfig = {
    apiKey: "AIzaSyCxCC1NFlOCM9k9pI4paC8vhJytSY4t054",
    authDomain: "estateon-e5287.firebaseapp.com",
    databaseURL: "https://estateon-e5287.firebaseio.com",
    projectId: "estateon-e5287",
    storageBucket: "estateon-e5287.appspot.com",
    messagingSenderId: "191717721261",
    appId: "1:191717721261:web:21f5dd3cdcc7985ecf7224",
    measurementId: "G-6RE4Q4XQHD"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
</script>
<script>
  window.onload = function() {
    // Listening for auth state changes.
  

    
    firebase.auth().onAuthStateChanged(function(user) {
      if (user) {
        // User is signed in.
        var uid = user.uid;
        var email = user.email;
        var photoURL = user.photoURL;
        var phoneNumber = user.phoneNumber;
        var isAnonymous = user.isAnonymous;
        var displayName = user.displayName;
        var providerData = user.providerData;
        var emailVerified = user.emailVerified;
      }
    });
    document.getElementById('verification-code-form').addEventListener('submit', onVerifyCodeSubmit);
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('sign-in-button', {
      'size': 'invisible',
      'callback': function(response) {
        onSignInSubmit()
      }
    });
    recaptchaVerifier.render().then(function(widgetId) {
      window.recaptchaWidgetId = widgetId;
      // updateSignInButtonUI();
    });
  }

  function onSignInSubmit() {
    console.log("dsfsf")
   // var phonenumber = document.getElementById("phone-number").value;
    var phoneumber = getPhoneNumberFromUserInput();
    console.log(phoneumber)
   isPhoneNumberValid()
    return false;
    // if (isPhoneNumberValid()) {
    window.signingIn = true;
    //   updateSignInButtonUI();
    var phoneNumber = getPhoneNumberFromUserInput();
    // console.log(phoneNumber);

    var appVerifier = window.recaptchaVerifier;
    firebase.auth().signInWithPhoneNumber("+917696070749", appVerifier)
      .then(function(confirmationResult) {

        window.confirmationResult = confirmationResult;
        window.signingIn = false;
        //   updateSignInButtonUI();
        //updateVerificationCodeFormUI();
        // //updateVerificationCodeFormUI();
        // updateSignInFormUI();
      }).catch(function(error) {

        console.error('Error during signInWithPhoneNumber', error);
        window.alert('Error during signInWithPhoneNumber:\n\n' +
          error.code + '\n\n' + error.message);
        window.signingIn = false;
        //  updateSignInFormUI();
        // updateSignInButtonUI();
      });
    //   }
  }

  function getCodeFromUserInput() {
    if (document.getElementById('verification-code').value != "") {
      return document.getElementById('verification-code').value;
    }
  }
  function getPhoneNumberFromUserInput() {
     return document.getElementById("phone-number").value;
    }
    function isPhoneNumberValid() {
     
      var x = document.getElementById("phone-number").value;
      if (isNaN(x) || x.length < 10 || x.length > 13) {
        console.log(x)
        console.log("NITIN")
        text = "Input not valid";
        console.log(text)
      } else {
        var re = '/^(?:\+?91|0)?/m';
        var phone = x
        var ccode = '+91';
        var result = phone.replace(re, ccode);
        console.log("NETIN")
        console.log(result);
      }
    }
  function onVerifyCodeSubmit(e) {
    e.preventDefault();
    if (!!getCodeFromUserInput()) {
      window.verifyingCode = true;
      //updateVerificationCodeFormUI();
      var code = getCodeFromUserInput();
      console.log(code)
      confirmationResult.confirm(code).then(function(result) {
        // User signed in successfully.
        console.log(result)
        var user = result.user;
        window.verifyingCode = false;
        window.confirmationResult = null;
        //updateVerificationCodeFormUI();
      }).catch(function(error) {
        // User couldn't sign in (bad verification code?)
        console.error('Error while checking the verification code', error);
        window.alert('Error while checking the verification code:\n\n' +
          error.code + '\n\n' + error.message);
        window.verifyingCode = false;
        //  updateSignInButtonUI();
        //updateVerificationCodeFormUI();
      });
    }
  }
</script>
@endsection