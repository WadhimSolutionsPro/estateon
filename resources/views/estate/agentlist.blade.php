@extends('layouts.estate')
@section('content')
<main>

    <!-- breadcrum -->
    <div class="breadcrum">
        <div class="container">
            <h1 class="breadcrumTittle">Our Agents</h1>
        </div>
    </div>
    <!-- Bredacrum Over -->

    <!-- featured property -->
    <section class="prop_list_view space">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="properties-ordering-wrapper">
                                <div class="results-count">
                                    Showing
                                    <span class="first">{{$user->firstItem()}}</span> – <span class="last">{{$user->lastItem()}}</span> of {{$user->total()}} results
                                </div>
                                <div class="properties-ordering">
                                    <form class="properties-ordering" method="get" action="https://www.demoapus-wp1.com/homeo/properties-list/">
                                        <div class="label">Sort by:</div>
                                        <select name="filter-orderby" class="orderby select2-hidden-accessible" data-placeholder="Sort by" tabindex="-1" aria-hidden="true">
                                            <option value="menu_order" selected="selected">Default</option>
                                            <option value="newest">Newest</option>
                                            <option value="oldest">Oldest</option>
                                            <option value="price-lowest">Lowest Price</option>
                                            <option value="price-highest">Highest Price</option>
                                            <option value="random">Random</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @foreach($user as $usr)
                        <div class="col-md-6 col-12">
                            <div class="list_view agent_view">
                                <div class="img-area agent_img">
                                    <div class="imgInner">
                                        @if($usr->avatar =="")
                                        <a href="{{route('user.detail',[$usr->slug])}}"> <img src="{{ url('uploads/images/userpic.jpg')}}" alt="image"></a>
                                        @else
                                        <a href="{{route('user.detail', [$usr->slug])}}"> <img src="{{$usr->avatar}}" alt="image"></a>
                                        @endif
                                    </div>
                                    <div class="overlay">
                                        <div class="over-text text-center">
                                            <h4 class="Agnt_name"><a href="{{route('user.detail', [$usr->slug])}}">{{$usr->name}}</a></h4>
                                            <p class="agent-des">Real Estate @foreach($usr->roles->pluck('name') as $role)
                                                {{ $role }}
                                                @endforeach
                                            </p>
                                            <p class="agent_mail"><a href="mailto:{{$usr->email}}">{{$usr->email}}</a></p>
                                        </div>
                                        <div class="catFooter agent-list">
                                            <div class="list_prop">
                                                <a href="{{route('user.detail', [$usr->slug])}}" class="">
                                                    <span class="count_posted">{{$usr->properties_count}}</span>
                                                    <span class="list-link">Listed Properties</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="col-12">
                            {{$user->links()}}
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="wht_box">
                        <h3>Latest Properties</h3>
                        <div class="latest_prop">
                            @foreach($data['latest'] as $latest)
                            <div class="media">
                                <a href="{{ route('property.detail', [$latest->slug] ) }}"><img src="{{$latest->images[0]['url']}}" alt="John Doe" class="lat-prop"></a>
                                <div class="media-body">
                                    <h3><a href="{{ route('property.detail', [$latest->slug] ) }}">{{$latest->name}}</a></h3>
                                    <p><span>&#8377;</span>{{$latest->property_details->price}}</p>
                                </div>
                            </div>
                            @endforeach
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