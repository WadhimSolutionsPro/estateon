@extends('layouts.admin')
@section('content')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href='{{ route("admin.user.subscription", ["active"=>true]) }}'>
            Active Plans
        </a>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>
                            {{ trans('cruds.usersubscription.fields.name') }}
                        </th>
                        <th>
                        {{ trans('cruds.usersubscription.fields.plan') }}   {{ trans('cruds.usersubscription.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.usersubscription.fields.start_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.usersubscription.fields.end_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.usersubscription.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usersubscription as $key => $subscription)
                    <tr data-entry-id="{{ $subscription->id }}">
                        <td>
                            {{ $subscription->user->name ?? '' }}
                        </td>
                        <td>
                            {{ $subscription->plan->name ?? '' }}
                        </td>
                        <td>
                        {{ date('d-M-y', strtotime($subscription->start_at)) }}
                        </td>
                        <td>
                        {{ date('d-M-y', strtotime($subscription->end_at)) }}
                        </td>
                        <td>
                        {{ $subscription->status==1 ? 'Active' : 'Inactive' }}
                        </td>
                        <td><div class="activation_button">
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.subscription.detail', $subscription->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                        </td>
                    </tr>
                    @endforeach
                <tfoot>
                    <tr>
                        <td colspan="12" class="text-center pgntion">
                        {{ $usersubscription->appends($params)->links() }}
                        </td>
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
    $(function() {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        let deleteButtonTrans = '{{ trans('
        global.datatables.delete ') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.users.massDestroy') }}",
            className: 'btn-danger',
            action: function(e, dt, node, config) {
                var ids = $.map(dt.rows({
                    selected: true
                }).nodes(), function(entry) {
                    return $(entry).data('entry-id')
                });

                if (ids.length === 0) {
                    alert('{{ trans('
                        global.datatables.zero_selected ') }}')

                    return
                }

                if (confirm('{{ trans('
                        global.areYouSure ') }}')) {
                    $.ajax({
                            headers: {
                                'x-csrf-token': _token
                            },
                            method: 'POST',
                            url: config.url,
                            data: {
                                ids: ids,
                                _method: 'DELETE'
                            }
                        })
                        .done(function() {
                            location.reload()
                        })
                }
            }
        }
        dtButtons.push(deleteButton)

        $.extend(true, $.fn.dataTable.defaults, {
            order: [
                [1, 'desc']
            ],
            pageLength: 100,
        });
        $('.datatable-User:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    })
</script>
@endsection