@extends('layouts.estate')
@section('content')
<main>
  <!-- breadcrum -->
  <div class="breadcrum">
    <div class="container">
      <h1 class="breadcrumTittle">Pricing</h1>
    </div>
  </div>
  <!-- Bredacrum Over -->
  <section class="ourplan space">
    <div class="container">
      <div class="centerTittle text-center">
        <h3 class="corner mb-md-4 mb-3">Choose Your Perfect Plan From Us</h3>
        <p>We provide full service at every step ipsum dolor sit amet, consec tetur cing elit. Suspe ndisse suscorem<br> ipsum dolor sit ametcipsum ipsumg consec tetur cing elitelit.</p>
      </div>
      <div class="row">
        @foreach($plans as $key=>$plan)
        <div class="col-md-4">
          <div class="pricing-grid">
            <h5 class="text-center">{{$plan->name}}</h5>
            <div class="price">&#8377; <span class="rupee">{{$plan->price}} </span> /{{$plan->time_in_monthes}} Month</div>
            {!! $plan->features !!}
            <div class="explore-plan">
            <form action="{{ route('payment.start') }}" method="POST" style="display: inline-block;">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="plan_id" value="{{$plan->id}}">
                                <input type="submit" class="cm-btn" value="Buy Plan">
                            </form>
              <!-- <a href="" rel="nofollow" class="cm-btn">Buy Plan</a> -->
            </div>
          </div>
        </div>
        @endforeach
      </div>
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