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
            <p>Welcome to EstateOn Property User </p>
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
          <div class="col-md-6">
              <div class="card">
                <div class="property-sale">
                  <div class="stat">
                    <div class="count">
                      {{$data['sales_count']}}
                    </div>
                    <h3>Properties for Sale</h3>
                    <!-- <p>Target 3k/month</p> -->
                  </div>
                  <!-- <div class="graph_area">
                    <input type="text" class="knob" value="71" data-width="150" data-height="150" data-fgColor="#ff635e"  data-readonly="true">
                  </div> -->
                </div>
            </div>  
            <!-- /.card -->
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="property-sale">
                <div class="stat">
                  <div class="count">
                  {{$data['rent_count']}}
                  </div>
                  <h3>Properties for Rent</h3>
                  <!-- <p>Target 3k/month</p> -->
                </div>
                <!-- <div class="graph_area">
                  <input type="text" class="knob" value="90" data-width="150" data-height="150" data-fgColor="#37d15a"  data-readonly="true">
                </div> -->
              </div>
          </div>  
          <!-- /.card -->
        </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

       
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection