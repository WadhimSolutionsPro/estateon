 <!-- Main Sidebar Container -->
 <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fa fa-bars"></i></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline search-strip ml-3">
    <!-- <div class="input-group input-group-md">
        <input class="form-control form-control-navbar" type="search" placeholder="Search Here" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div> -->
      <div class="user-panel mr-3 mt-2 d-flex">
        <div class="info">
          <a href="#" class="d-block text-white">{{ Auth::user()->name }}</a>
        </div>
        <div class="image">
          <img src="{{ url('dashboard/images/my-profile.png')}}" class="elevation-2" alt="User Image">
        </div>
      </div>
    </form>
      
  </nav>
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('frontuser.home.index') }}" class="brand-link text-center">
      <img src="{{ url('dashboard/images/logo.png')}}" alt="EstateOn logo" class="brand-id">
      <img src="{{ url('dashboard/images/small-icon.png')}}" alt="EstateOn logo" class="small-icon">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
                <a href="{{ route('frontuser.home.index') }}" class="nav-link {{ request()->is('frontuser/home') || request()->is('frontuser/home/*') ? 'active' : '' }}">
                  <img src="{{ url('dashboard/images/dashboard.png')}}" alt="dashboard-image" class="nav-icon">
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('frontuser.property.index') }}" class="nav-link {{ request()->is('frontuser/property') || request()->is('frontuser/property/*') ? 'active' : '' }}">
                  <img src="{{ url('dashboard/images/proerties.png')}}" alt="dashboard-image" class="nav-icon">
                  <p>
                    Properties
                  </p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="pages/queries.html" class="nav-link">
                  <img src="{{ url('dashboard/images/queris.png')}}" alt="dashboard-image" class="nav-icon">
                  <p>
                    Queries
                  </p> <span class="new-queries">32</span>
                </a>
              </li> -->

              <!-- <li class="nav-item">
                <a href="pages/myprofile.html" class="nav-link">
                  <img src="{{ url('dashboard/images/profile.png')}}" alt="dashboard-image" class="nav-icon">
                  <p>
                    My Profile
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/subscriptions.html" class="nav-link">
                  <img src="{{ url('dashboard/images/subscribe.png')}}" alt="dashboard-image" class="nav-icon">
                  <p>
                    Subscription
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/changepassword.html" class="nav-link">
                  <img src="{{ url('dashboard/images/password.png')}}" alt="dashboard-image" class="nav-icon">
                  <p>
                    Change Password
                  </p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();"> 
                  <img src="{{ url('dashboard/images/logout.png')}}" alt="dashboard-image" class="nav-icon">
                  <p>
                    Log Out
                  </p>
                </a>
              </li>
          </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>