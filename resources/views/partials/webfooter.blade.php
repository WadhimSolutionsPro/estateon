<div class="container">
  <div class="row">
    <div class="col-lg-4 col-md-6 mb-4">
      <div class="ftr-title">
        <h3>About Site</h3>
      </div>
      <p class="wht">
        We’re reimagining how you buy, sell and rent. It’s now easier to
        get into a place you love. So let’s do this, together.
      </p>
    </div>
    <div class="col-lg-2 col-md-6 col-12 mb-4">
      <div class="ftr-title">
        <h3>Quick Links</h3>
      </div>
      <div class="ftr_links">
        <ul>
          <li><a href="{{ route('page.aboutus') }}">About us</a></li>
          <li><a href="{{ route('page.tandc') }}">Terms & Conditions</a></li>
          <li><a href="{{ route('page.userguide') }}">User's Guide</a></li>
          <li><a href="{{ route('page.faq') }}">FAQ's</a></li>
          <li><a href="{{ route('page.contact') }}">Contact</a></li>
        </ul>
      </div>
    </div>
    <div class="col-lg-2 col-md-6 col-12 mb-4">
      <div class="ftr-title">
        <h3>Contact Us</h3>
      </div>
      <ul class="cntct-list">
        <li>
          <a href="mailto:info@estateon.com">info@estateon.com</a>
        </li>
        <li>
          <address>Old street IT Park 8007, Mumbai India</address>
        </li>
        <li><a href="tel:+91 99262 66888">+91 99262 66888</a></li>
      </ul>
    </div>
    <div class="col-lg-4 col-md-6 col-12 mb-4 in-ftrs">
      <div class="ftr-title">
        <h3>Follow Us</h3>
      </div>
      <ul class="share-icon mt-3">
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
        </li> -->
      </ul>
      <div class="ftr-title">
        <h3>Subscribe</h3>
        <form action="">
          <div class="form-group">
            <input type="text" placeholder="Your Email" />
            <button><i class="fas fa-chevron-right"></i></button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <a href="" onclick="topFunction()" id="gotoTop" title="Go to top"><span class="go_top"></span></a>
</div>
<div class="text-center copyright">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <p class="wht Copyrighttxt">
          Estate On Copyright © 2021 All rights reserved.
        </p>
      </div>
    </div>
  </div>
</div>
<a href="#" class="scrollToTop"><span class="go_top"></span></a>
<script src="{{ url('estate/js/min/jquery-3.4.1.min.js')}}" integrity="" crossorigin="anonymous"></script>
<script src="{{ url('estate/js/popper.min.js')}}"></script>
<script src="{{ url('estate/js/bootstrap.min.js')}}"></script>
<script src="{{ url('estate/js/slick.js')}}"></script>
<script src="{{ url('estate/js/wow.min.js')}}"></script>
<script src="{{ url('estate/js/min/main-min.js')}}"></script>
<script>
  $(window).scroll(function() {
    var sticky = $('.header'),
      scroll = $(window).scrollTop();

    if (scroll >= 100) sticky.addClass('fixed');
    else sticky.removeClass('fixed');
  });
  setTimeout(function() {
    $("body").addClass("loaded");
  }, 500);
</script>