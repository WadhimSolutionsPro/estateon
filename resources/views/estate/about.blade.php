@extends('layouts.estate')
@section('content')
<main>
      <!-- breadcrum -->
      <div class="breadcrum">
        <div class="container">
          <h1 class="breadcrumTittle">About us</h1>
        </div>
      </div>
      <!-- Bredacrum Over -->
      <section class="ourMisson space">
        <div class="container">
          <div class="centerTittle">
            <h3 class="corner text-center">
              Our Mission Is To Sell and Rent Properties
            </h3>
          </div>
          <div class="row">
            <div class="col-md-8">
              <h5>
                Please have a look at the atmosphere of our company
              </h5>
              <p class="mb-3">
                The founder serving the industry science 2008, having experience 13+ year and counting in various city across India starting from Indore,and got chance to work in Mumbai, Ahmadabad Jaipur Nagpur Raipur Bhopal etc.
              </p>
              <p class="mb-3">
                Founded company in 2019 with the vision of to provide best and value for money property options with all legal and transparent way to organize a proper system with corporate culture in real estate service industry.
              </p>
              <p class="mb-3">
                To solve all the major problem people are facing during real estate buying selling and lease process lack of transparency proper guidance and communication with actual facts.
                We have vision to provide all A to Z facilities like buying selling lease all under one roof 
              </p>
              <p class="mb-3">
              Estateon.com is the perfect destination for all Buyer,Builders and agents. With the help of modern technology and our trained and specialized team, we play a part as bridge between all of them.
              </p>
              <p class="mb-3">
              The world is changing very fast every industry has to change with the time we wish to organized real estate industry as like other corporate sectors are.
              </p>
              <p class="mb-3">
              Here not only buyer gets sellers seller got there need but we love to help them to complete their deal with our expert guidance without any trouble and fulfill all legal aspects.
              </p>
              <p class="mb-3">
              And bring trust of the more and more common people and investors as well in real estate investment, As compare to other investment sectors like gold,bodns share market,insurance and traditional saving pattern etc. 
              </p>
              <div class="propertyCount">
                <div class="row">
                  <div class="col-md-4">
                    <div class="media counters">
                      <div class="mediaIcon">
                        <i class="far fa-user"></i>
                      </div>
                      <div class="media-body">
                        <h5 class="mt-0">80,123</h5>
                        <p>Customer upto date</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="media counters">
                      <div class="mediaIcon">
                        <i class="fas fa-home"></i>
                      </div>
                      <div class="media-body">
                        <h5 class="mt-0">12,123</h5>
                        <p>Propert Sale</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="media counters">
                      <div class="mediaIcon">
                        <i class="fab fa-pagelines"></i>
                      </div>
                      <div class="media-body">
                        <h5 class="mt-0">80,123</h5>
                        <p>Property Rent</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="aboutText">
                <img src="{{ url('estate/images/abouside.png')}}" alt="" class="img-fluide" />
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="space WhyChoose">
        <div class="container">
          <div class="centerTittle">
            <h3 class="corner text-center">Why Choose Us</h3>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="inerCAt">
                <div class="serviceIcon">
                  <i class="fas fa-users"></i>
                </div>
                <div class="seviceText">
                  <h4>Lorem Ipsum</h4>
                  <p>
                    Aliquam dictum elit vitae mauris facilisis at dictum vitae
                    mauris urna dignissim donec vel lectus vel felis.
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="inerCAt">
                <div class="serviceIcon">
                  <i class="fas fa-house-user"></i>
                </div>
                <div class="seviceText">
                  <h4>Lorem Ipsum</h4>
                  <p>
                    Aliquam dictum elit vitae mauris facilisis at dictum vitae
                    mauris urna dignissim donec vel lectus vel felis.
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="inerCAt">
                <div class="serviceIcon">
                  <i class="fas fa-landmark"></i>
                </div>
                <div class="seviceText">
                  <h4>Lorem Ipsum</h4>
                  <p>
                    Aliquam dictum elit vitae mauris facilisis at dictum vitae
                    mauris urna dignissim donec vel lectus vel felis.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- our agents -->
      <section class="video_sec Agents space featured">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="head_title">
                <h3 class="corner">Our Agents</h3>
              </div>
              <ul class="v_slides">
                <li class="v-inner text-center">
                  <div class="img-area">
                    <div class="imgInner">
                      <a href="#">
                        <img
                          src="{{ url('estate/images/Agen1.png')}}"
                          class="img-fluid"
                          alt="image"
                      /></a>
                    </div>
                    <div class="overlay">
                      <div class="over-text">
                        <h4 class="BuildingName agentName">
                          <a href="#">Prabhu Naga</a>
                        </h4>
                        <div class="text-center">
                          <p class="desig">Sale Expert</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="v-inner text-center">
                  <div class="img-area">
                    <div class="imgInner">
                      <a href="#">
                        <img
                          src="{{ url('estate/images/agent2.png')}}"
                          class="img-fluid"
                          alt="image"
                      /></a>
                    </div>
                    <div class="overlay">
                      <div class="over-text">
                        <h4 class="BuildingName agentName">
                          <a href="#">Prabhu Naga</a>
                        </h4>
                        <div class="text-center">
                          <p class="desig">Sale Expert</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="v-inner text-center">
                  <div class="img-area">
                    <div class="imgInner">
                      <a href="#">
                        <img
                          src="{{ url('estate/images/agent3.png')}}"
                          class="img-fluid"
                          alt="image"
                      /></a>
                    </div>
                    <div class="overlay">
                      <div class="over-text">
                        <h4 class="BuildingName agentName">
                          <a href="#">Prabhu Naga</a>
                        </h4>
                        <div class="text-center">
                          <p class="desig">Sale Expert</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="v-inner text-center">
                  <div class="img-area">
                    <div class="imgInner">
                      <a href="#">
                        <img
                          src="{{ url('estate/images/agent4.png')}}"
                          class="img-fluid"
                          alt="image"
                      /></a>
                    </div>
                    <div class="overlay">
                      <div class="over-text">
                        <h4 class="BuildingName agentName">
                          <a href="#">Prabhu Naga</a>
                        </h4>
                        <div class="text-center">
                          <p class="desig">Sale Expert</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="v-inner text-center">
                  <div class="img-area">
                    <div class="imgInner">
                      <a href="#">
                        <img
                          src="{{ url('estate/images/Agen1.png')}}"
                          class="img-fluid"
                          alt="image"
                      /></a>
                    </div>
                    <div class="overlay">
                      <div class="over-text">
                        <h4 class="BuildingName agentName">
                          <a href="#">Prabhu Naga</a>
                        </h4>
                        <div class="text-center">
                          <p class="desig">Sale Expert</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>
    </main>
@endsection
@section('scripts')
<script>
  $(document).ready(function(){
    jQuery(".v_slides").slick({
        infinite: true,
        autoplay: true,
        dots: false,
        autoplaySpeed: 3000,
        slidesToShow: 4,
        slidesToScroll: 1,
        speed: 500,
        arrows: true,
        prevArrow:
          "<button type='button' class='slick-prev slide-btn'><i class='fas fa-chevron-left' aria-hidden='true'></i></button>",
        nextArrow:
          "<button type='button' class='slick-next slide-btn'><i class='fas fa-chevron-right' aria-hidden='true'></i></button>",
      });
  })
 </script>
@endsection