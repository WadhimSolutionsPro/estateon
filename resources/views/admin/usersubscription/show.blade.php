@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.usersubscription.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.usersubscription.fields.name') }}
                        </th>
                        <td>
                            {{ $usersubscription->user->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.usersubscription.fields.amount') }}
                        </th>
                        <td>
                            {{ $usersubscription->plan->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.usersubscription.fields.start_date') }}
                        </th>
                        <td>
                        {{ date('d-M-y', strtotime($usersubscription->start_at)) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.usersubscription.fields.end_date') }}
                        </th>
                        <td>
                        {{ date('d-M-y', strtotime($usersubscription->end_date)) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Amount Paid
                        </th>
                        <td>
                        {{$usersubscription->payment->amount}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                           Transaction Id
                        </th>
                        <td>
                        {{$usersubscription->payment->txnid}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                         Payment Date
                        </th>
                        <td>
                        {{ date('d-M-y', strtotime($usersubscription->payment->date)) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                        Status
                        </th>
                        <td>
                        {{$usersubscription->status ==1 ? 'Active' : 'inactive' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>


    </div>
</div>
@endsection