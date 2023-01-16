<div class="header_padd">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="nav-custom">
                    <nav class="navbar navbar-expand-lg">
                        <div class="logo-animate">
                            <a href="/" class="site-logo navbar-brand">
                                <img src="{{ url('estate/images/logo.png')}}" alt="" />
                            </a>
                        </div>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon" id="">
                                <div class="bar1"></div>
                                <div class="bar2"></div>
                                <div class="bar3"></div>
                            </span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route("home.index") }}">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('page.aboutus') }}">About Us</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('property.list')}}">Properties</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('user.agent')}}">Our Agents</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        More <i class="fas fa-angle-down"></i>
                                    </a>
                                    <div class="dropdown-menu scnd_down" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('page.faq') }}">Faq's</a>
                                        @auth('frontuser')
                                        <!-- <a class="dropdown-item" href="{{ route('page.pricing') }}">Pricing</a> -->
                                        @endauth
                                        <a class="dropdown-item" href="{{ route('page.contact') }}">Contact Us</a>
                                    </div>
                                </li>        
                                @auth('frontuser')
                                <li class="nav-item">
                                    <a class="add-prp cm-btn d-lg-block" href="{{ route("frontuser.property.create") }}">Post Property </a>
                                </li>
                                @endauth
                            </ul>
                        </div>
                    </nav>
                    <div class="pipe d-lg-block d-none">|</div>
                    <div class="sign">
                        <ul>
                            @guest('frontuser')
                            <li class="d-lg-block d-none"><a href="{{ route("home.signin") }}" class="sign-link">Post Property Free </a></li>
                            @endguest

                            @auth('frontuser')
                            <li class="wishlist_hd">
                                <a href="{{ route('page.wishlist') }}" class=""><span><img src="{{ url('estate/images/heart.png')}}" /></span></a>
                            </li>
                            <li class="add_prop_hd">
                                <a href="#" class="add-prp add_propty d-lg-none d-block"><img src="images/home_icon.png">
                                    <span><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                            </li>

                            <li>
                                <a href="{{ route('frontuser.home.index') }}" class="add-prp cm-btn d-lg-block d-none"><span></span>Dashboard</a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}">
                                    Logout
                                </a>
                            </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>