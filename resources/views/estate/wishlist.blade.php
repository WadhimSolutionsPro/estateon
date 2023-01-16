@extends('layouts.estate')
@section('content')
<main>
      
      <!-- breadcrum -->
      <div class="breadcrum">
        <div class="container">
          <h1 class="breadcrumTittle">Favorites Properties</h1>
        </div>
      </div>
      <!-- Bredacrum Over -->
      
<!-- featured property -->
<section class="prop_list_view space">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
          @foreach($properties as $property)
             <div class="col-md-6 col-lg-4 col-12">
              <div class="list_view">
                <div class="img-area">
                  <div class="imgInner">
                  <a href="{{ route('property.detail', [$property->slug] ) }}">  <img src="{{$property->images[0]['url']}}" alt="image"></a>
                  @auth
                @if($property->likes_count > 0)
                <a class="likeBtn" data-propertyid="{{$property->id}}"><i class="fas fa-heart"></i> </a>
                @endif
                @if($property->likes_count == 0)
                <a class="likeBtn" data-propertyid="{{$property->id}}"><i class="far fa-heart"></i> </a>
                @endif
                @endauth
                  </div>
                  <div class="overlay">
                    <div class="over-text">
                        <p class="propertyArea">{{$property->property_type->type_data->name}}</p>
                        
                      <h4  class="BuildingName">
                        <a href="{{ route('property.detail', [$property->slug] ) }}">{{$property->name}}</a>
                      </h4>
                      <div class="location">
                          <i class="fas fa-map-marker-alt mr-2"> </i> <a class="locationArea" title="{{$property->address}}">{{\Illuminate\Support\Str::limit($property->address, 35, $end='...')}}</a>
                      </div>  
                    </div>
                    
                    <div class="catFooter">
                          <p class="flatPrice">₹ <span>{{$property->property_details->price}}</span></p>
                          <a href="{{ route('property.detail', [$property->slug] ) }}" class="cm-btn">{{$property->type}}</a>
                    </div>
                  </div>
                </div>
              </div>
             </div>
             @endforeach
              <div class="col-12">
              {{ $properties->links() }}
              </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
<!-- newsletter -->
      <section class="newsltter space ">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-6"col-lg-4 >
              <div class="newsletterText">
                  <h2 class="newsheading">Become a real Estate Agent</h2>
                  <p>We only work with the best companies around the globe</p>
              </div>
            </div>
            <div class="col-md-6"col-lg-4 >
              <div class="subcibeBtn">
                  <button class="cm-btn register-btn">Register Now</button>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
@endsection