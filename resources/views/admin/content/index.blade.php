@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Page Content List
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Role">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            ID
                        </th>
                        <th>
                            Page
                        </th>
                        <th>
                            Content
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($content as $key => $contentSingle)
                        <tr data-entry-id="{{ $contentSingle->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $contentSingle->id ?? '' }}
                            </td>
                            <td>
                                {{ ucfirst($contentSingle->page_key) ?? '' }}
                            </td>
                            <td>
                                <div style="max-height: 200px;overflow: hidden">
                                    {!!html_entity_decode($contentSingle->content)!!}
                                </div>
                            </td>
                            <td>                            
                                
                                <a class="btn btn-xs btn-info" href="{{ route('admin.content.edit', $contentSingle->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                                <form action="{{ route('admin.content.destroy', $contentSingle->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Role:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection