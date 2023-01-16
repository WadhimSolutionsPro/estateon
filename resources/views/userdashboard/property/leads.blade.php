@extends('layouts.dashboard')
@section('content') 

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 dflx">
                    <h1 class="m-0">Show Leads</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="add_pprty space">
        <div class="container-fluid">
        @foreach($data['leads'] as $lead)
                    <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                    <th>
                            Name:
                        </th>
                        <td>
                            {{ $lead->name }}
                        </td>
                        <th>
                            Email:
                        </th>
                        <td>
                            {{ $lead->email }}
                        </td>
                        <th>
                            Phone:
                        </th>
                        <td>
                            {{ $lead->phone }}
                        </td>
                        <th>
                            Message:
                        </th>
                        <td>
                            {{ $lead->message }}
                        </td>
                        
                    </tr>
                    </tbody>
            </table>    
                    @endforeach
        </div>
    </section>
</div>

@endsection