@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        Show Leads
    </div>
    <div class="card-body">
        <div class="mb-2">
            
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
                    
                
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>
@endsection