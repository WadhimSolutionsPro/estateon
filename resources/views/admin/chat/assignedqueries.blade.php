@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>{{ trans('cruds.queries.title') }} {{ trans('global.list') }}</h3>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>
                            {{ trans('cruds.queries.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.queries.fields.from_user') }}
                        </th>
                        <th>
                            {{ trans('cruds.queries.fields.property_address') }}
                        </th>
                        <th>

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignedqueries as $key => $query)
                    <tr data-entry-id="{{ $query->id }}">
                        <td>
                            {{ $query->id ?? '' }}
                        </td>
                        <td>
                            <a href="{{ route('admin.users.show', $query->conversastion->fromuser->id) }}">
                                {{ $query->conversastion->fromuser->name ?? '' }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.property.show', $query->property->id) }}">
                                {{ $query->property->address ?? '' }}
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.assistant.message', $query->id) }}">
                                Message
                            </a>
                        </td>
                    </tr>
                    @endforeach
                <tfoot>
                    <tr>
                        <td colspan="6">{{ $assignedqueries->links() }}</td>
                    </tr>
                </tfoot>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(document).ready(function() {
      
    })
</script>
@endsection