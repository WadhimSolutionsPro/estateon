@extends('layouts.estate')
@section('content')
<main>

    <!-- breadcrum -->
    <div class="breadcrum">
        <div class="container">
            <h1 class="breadcrumTittle">Gourv Bansal</h1>
        </div>
    </div>
    <!-- Bredacrum Over -->

    <section class="pprty_detail space">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="list_view agent_view detail_agent mb-3">
                                <div class="img-area agent_img mb-0">
                                    <div class="imgInner">
                                        @if($data['user']->avatar =="")
                                        <img src="{{ url('uploads/images/userpic.jpg')}}" alt="image">
                                        @else
                                        <img src="{{$data['user']->avatar}}" alt="image">
                                        @endif
                                    </div>
                                    <div class="overlay">
                                        <div class="over-text text-left">
                                            <h4 class="Agnt_name">{{$data['user']->name}}</h4>
                                            <p class="agent-des">Real Estate @foreach($data['user']->roles->pluck('name') as $role)
                                                {{ $role }}
                                                @endforeach
                                            </p>
                                            @if($data['user']->phone != "")
                                            <p class="agent_phn">Phone:- <i><a href="tel:{{$data['user']->phone}}"> {{$data['user']->phone}}</a></i></p>
                                            @endif
                                            @if($data['user']->email != "")
                                            <p class="agent_mail">Email:- <i><a href="mailto:{{$data['user']->email}}">{{$data['user']->email}}</a></i></p>
                                            @endif
                                        </div>
                                        <div class="agent-list agent_de_list">
                                            <div class="list_prop">
                                                <span class="count_posted">{{$data['user']->properties_count}}</span>
                                                <span class="list-link">Listed Properties</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($data['user']->detail != "")
                            <div class="wht_box">
                                <h3>Overview</h3>
                                <p class="mb-3">
                                    {{$data['user']->detail}}
                                </p>
                            </div>
                            @endif
                            <div class="wht_box pb-0">
                                <h3>Listed Properties</h3>
                                <div class="row">
                                    @foreach($data['user']->properties as $prop)
                                    <div class="col-md-6 col-12">
                                        <div class="list_view">
                                            <div class="img-area">
                                                <div class="imgInner">
                                                    @if(isset($prop->images[0]))
                                                    <a href="{{ route('property.detail', [$prop->slug] ) }}"> <img src="{{$prop->images[0]['url']}}" alt="image"></a>
                                                    @endif
                                                    @auth
                                                    <a href="{{ route('property.detail', [$prop->slug] ) }}" class="likeBtn"><i class="far fa-heart"></i> </a>
                                                    @endauth
                                                    <!-- <a href="#" class="likeBtn" data-toggle="tooltip" title="Wishlist" data-placement="top">
                           <i class="far fa-heart"></i>
                         </a> -->
                                                </div>
                                                <div class="overlay">
                                                    <div class="over-text">
                                                        <p class="propertyArea">{{$prop->property_type->type_data->name}}</p>

                                                        <h4 class="BuildingName">
                                                            <a href="{{ route('property.detail', [$prop->slug] ) }}">{{$prop->name}}</a>
                                                        </h4>
                                                        <div class="location">
                                                            <i class="fas fa-map-marker-alt mr-2"> </i> <a class="locationArea" title="{{$prop->address}}">{{\Illuminate\Support\Str::limit($prop->address, 35, $end='...')}}</a>
                                                        </div>
                                                    </div>

                                                    <div class="catFooter">
                                                        <p class="flatPrice">₹ <span>{{$prop->property_details->price}}</span></p>
                                                        <a href="{{ route('property.detail', [$prop->slug] ) }}" class="cm-btn">{{$prop->type}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12">
                            <div class="wht_box in-resp">
                                <div class="contact_for_prp">
                                    <h3>Contact Agent</h3>
                                    <form id="contact-agent" action="#!">
                                        <div class="form-group">
                                            <input type="name" name="name" id="name" class="form-control" placeholder="Name" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="phone" name="phone" id="phone" class="form-control" placeholder="Phone Number" required>
                                        </div>
                                        <div class="form-group mb-4">
                                            <textarea class="form-control" rows="4" id="message" placeholder="Message" required></textarea>
                                        </div>
                                        <button class="cm-btn w-100" id="contact-agent-button">send message</button>
                                    </form>
                                </div>
                            </div>

                            <div class="wht_box mt-4">
                                <h3>Latest Properties</h3>
                                <div class="latest_prop">
                                    <div class="media">
                                        <a href=""><img src="images/samll-1.jpg" alt="John Doe" class="lat-prop"></a>
                                        <div class="media-body">
                                            <h3><a href="#">Diamond Manor Apartment</a></h3>
                                            <p><span>&#8377;</span> 6,500</p>
                                        </div>
                                    </div>

                                    <div class="media">
                                        <a href=""><img src="images/samll-2.jpg" alt="John Doe" class="lat-prop"></a>
                                        <div class="media-body">
                                            <h3><a href="#">Eaton Garth Penthouse</a></h3>
                                            <p><span>&#8377;</span> 7,500</p>
                                        </div>
                                    </div>

                                    <div class="media">
                                        <a href=""><img src="images/samll-3.jpg" alt="John Doe" class="lat-prop"></a>
                                        <div class="media-body">
                                            <h3><a href="#">Skyper Pool Apartment</a></h3>
                                            <p><span>&#8377;</span> 12,500</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
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