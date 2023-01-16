@extends('layouts.estate')
@section('content')
<main>
      <!-- breadcrum -->
      <div class="breadcrum cont-brd">
        <div class="container">
          <h1 class="breadcrumTittle">Contact us</h1>
        </div>
      </div>
      <!-- Bredacrum Over -->
      <section class="cont-reg space">
        <div class="container">
          <div class="row no-gutters cont-boxs">
            <div class="col-md-5">
              <div class="cont-info">
                <div class="head_title">
                  <h3 class="corner wht">Contact Info</h3>
                </div>
                <ul>
                  <li>
                    <div class="in-list">
                      <span>
                        <img src="{{ url('estate/images/location.png')}}" alt="icon">
                      </span>
                      <address class="mb-0">Home Inc. 555 Old street IT Park 8007, Mumbai India</address>
                    </div>
                  </li>
                  <li>
                    <div class="in-list">
                      <span>
                        <img src="{{ url('estate/images/email.png')}}" alt="icon">
                      </span>
                      <a href="mailto:info@estateon.com">info@estateon.com</a>
                    </div>
                  </li>
                  <li>
                    <div class="in-list">
                      <span>
                        <img src="{{ url('estate/images/call.png')}}" alt="icon">
                      </span>
                      <a href="tel:+1 246-345-0695">+1 246-345-0695</a>
                    </div>
                  </li>
                  <li>
                    <div class="in-list">
                      <span>
                        <img src="{{ url('estate/images/web.png')}}" alt="icon">
                      </span>
                      <a href="www.estateon.com">www.estateon.com</a>
                    </div>
                  </li>
                </ul>
                <div class="social-icon">
                  <ul class="share-icon">
                    <li>
                      <a href="https://www.facebook.com/EstateOnline" class="pl-0"><i class="fab fa-facebook-f"></i></a>
                    </li>
                    <!-- <li>
                      <a href="#"><i class="fab fa-twitter"></i></a>
                    </li> -->
                    <li>
                      <a href="https://www.instagram.com/eoninfratech/"><i class="fab fa-instagram"></i></a>
                    </li>
                    <!-- <li>
                      <a href="#"><i class="fab fa-pinterest-p"></i></a>
                    </li>
                    <li>
                      <a href="#"><i class="fab fa-google"></i></a>
                    </li> -->
                  </ul>
                </div>
              </div>
              
            </div>
            <div class="col-md-7">
              <div class="cont-form">
                <div class="head_title">
                  <h3 class="corner">We're always eager to hear from you!</h3>
                  <p>Lorem ipsum dolor sit amet, consec tetur cing elit. Suspe ndisse suscorem ipsum dolor 
                    sit  ametcipsum  ipsumg consec tetur cing elitelit.</p>
                </div>
                <form action="#!">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="name" name="name" id="name" class="form-control" placeholder="Full Name">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="phone" name="phone" id="phone" class="form-control" placeholder="Phone Number">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email Address">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group mb-4">
                        <textarea class="form-control" rows="3" id="message" placeholder="Message"></textarea>
                      </div>
                    </div>
                    <div class="col-6 ml-md-auto">
                       <button class="cm-btn w-100">Submit</button>
                    </div>
                  </div>
                </form> 
              </div>
            </div>
          </div>
        </div>
      </section>
      
      <section class="map-view">
        <div class="map-area">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d42661.904812410554!2d72.88109333594925!3d19.071857807068294!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c6306644edc1%3A0x5da4ed8f8d648c69!2sMumbai%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1614344043672!5m2!1sen!2sin" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
      </section>
      
      <section class="newsltter space ">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-6">
              <div class="newsletterText">
                  <h2 class="newsheading">Become a real Estate Agent</h2>
                  <p>We only work with the best companies around the globe</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="subcibeBtn">
                  <button class="cm-btn register-btn">Register Now</button>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
@endsection