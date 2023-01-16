@extends('layouts.dashboard')
@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Dashboard</h1>
            <p>Welcome to EstateOn Property Admin </p>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12">
            <div class="info-box state_box mb-3 site-bg">
              <span class="info-box-icon"><i class="fas fa-home"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Properties</span>
                <span class="info-box-number">4,562</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                  70% Increase in 30 Days
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </div>
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-md-6">
              <div class="card">
                <div class="property-sale">
                  <div class="stat">
                    <div class="count">
                      1,050
                    </div>
                    <h3>Properties for Sale</h3>
                    <p>Target 3k/month</p>
                  </div>
                  <div class="graph_area">
                    <input type="text" class="knob" value="71" data-width="150" data-height="150" data-fgColor="#ff635e"  data-readonly="true">
                  </div>
                </div>
            </div>  
            <!-- /.card -->
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="property-sale">
                <div class="stat">
                  <div class="count">
                    2,206
                  </div>
                  <h3>Properties for Rent</h3>
                  <p>Target 3k/month</p>
                </div>
                <div class="graph_area">
                  <input type="text" class="knob" value="90" data-width="150" data-height="150" data-fgColor="#37d15a"  data-readonly="true">
                </div>
              </div>
          </div>  
          <!-- /.card -->
        </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="">Total Revenue</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">₹ 12,400,00.00</span>
                    <span>Sales Over Time</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 33.1%
                    </span>
                    <span class="text-muted">Since last month</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="300"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> This year
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Last year
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection