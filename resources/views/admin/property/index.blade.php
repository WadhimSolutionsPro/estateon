@extends('layouts.admin')
@section('content')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route("admin.property.create") }}">
            {{ trans('global.add') }} {{ trans('cruds.property.title_singular') }}
        </a>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3>{{ trans('cruds.property.title_singular') }} {{ trans('global.list') }}</h3>
    </div>
    <div class="card-body">
        <div class="filter-area in-flx">
            <div class="card-tools">
                <h4>Filter</h4>
            </div>
            <form action="{{ route('admin.property.index') }}" class="filter-item">
                <div class="input-group input-group-sm">
                    <div class="fea">
                        <label>Features</label>
                        <select name="filter_type[]" id="filter_type" class="form-control select2">
                            <option value="amenities" {{in_array('amenities', $filtertype)  ? 'selected' : ''}}>Amenities</option>
                            <option value="vastu" {{in_array('vastu', $filtertype)  ? 'selected' : ''}}>Vastu</option>
                            <option value="property_type" {{in_array('property_type', $filtertype)  ? 'selected' : ''}}>Property Type</option>
                        </select>
                    </div>
                    <div class="fea">
                        <label>Type</label>
                        <select name="pr_type[]" id="pr_type" class="form-control select2">
                            <option value="sale" {{in_array('sale', $property_type)  ? 'selected' : ''}}>Sale</option>
                            <option value="rent" {{in_array('rent', $property_type)  ? 'selected' : ''}}>Rent</option>
                        </select>
                    </div>
                    <div class="fea">
                        <label>Like</label>
                        <div class="srch-right">
                            <div class="input-group-append">
                                 <input type="text" name="q" class="form-control search_list" placeholder="Search" value="{{ request()->get('q') }}" required>
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div> 
                    </div>
                </div>
            </form> 
        </div>
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.id') }}
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Posted By
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.address') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.amenities') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.vastu') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.preferences') }}
                        </th>
                        <!-- <th>
                            {{ trans('cruds.property.fields.property_type') }}
                        </th> -->
                        <!-- <th>
                            {{ trans('cruds.property.fields.featured') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.hot') }}
                        </th> -->
                        <th class="all_btn_selections">
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($properties as $key => $property)
                    <tr data-entry-id="{{ $property->id }}">
                    <td>
                            {{ $property->id ?? '' }}
                        </td>                        
                        <td>
                            {{ $property->name ?? '' }}
                        </td>
                        <td>                            
                            <span class="badge badge-success">{{$property->posted_by}}</span>
                        </td>
                        <td>
                            {{ $property->address ?? '' }}
                        </td>
                        <td>
                            {{ $property->type ?? '' }}
                        </td>
                        <td>
                            @foreach($property->amenities as $amenity)
                            <span class="badge badge-info">{{ $amenity['amenity_data']['name']  ?? ''}}</span>

                            @endforeach
                        </td>
                        <td>

                            <span class="badge badge-info">{{ $property->vastu['vastu_data']['name']  ?? ''}}</span>

                        </td>
                        <td>
                            @foreach($property->preferences as $preference)
                            <span class="badge badge-info">{{ $preference['preferences_data']['name']  ?? ''}}</span>
                            @endforeach
                        </td>
                        <!-- <td>
                            <span class="badge badge-info">{{ $property->property_type['type_data']['name']  ?? ''}}</span>

                        </td> -->
                        <!-- <td>
                            {{ $property->featured==1 ? 'true':'false' }}
                        </td>
                        <td>
                            {{ $property->hot==1 ? 'true':'false' }}
                        </td> -->
                        <td> 
                            <div class="activation_button">
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.property.show', $property->id) }}">
                                {{ trans('global.view') }}
                            </a>

                            <a class="btn btn-xs btn-primary" href="{{ route('admin.property.leads', $property->id) }}">
                                Leads
                            </a>

                            <a class="btn btn-xs btn-info" href="{{ route('admin.property.edit', $property->id) }}">
                                {{ trans('global.edit') }}
                            </a>
                            </div>
                            <div>
                            <a class="btn btn-xs btn-info" href="{{ route('admin.property.image', $property->id) }}">
                                {{ trans('cruds.property.fields.image') }}
                            </a>
                            <a class="btn btn-xs btn-info" href="{{ route('admin.property.conversastion', $property->id) }}">
                                {{ trans('cruds.property.fields.queries') }}
                            </a>
                            </div> <div>
                            @if($property->approved==0)
                            <a class="btn btn-xs btn-success" href="{{ route('admin.property.changestatus', [$property->id, 'approve'] ) }}">
                                {{ trans('cruds.property.fields.approve') }}
                            </a>
                            @endif
                            @if($property->approved==0)
                            <form action="{{ route('admin.property.destroy', $property->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn-xs btn-danger" value="{{  trans('cruds.property.fields.reject') }}">
                            </form>
                            @endif
                            </div>
                            @if($property->status==0)
                            <a class="btn btn-xs btn-success" href="{{ route('admin.property.changestatus', [$property->id, 'activate'] ) }}">
                                {{ trans('cruds.property.fields.active') }}
                            </a>
                            @endif
                            @if($property->status==1)
                            <a class="btn btn-xs btn-danger" href="{{ route('admin.property.changestatus', [$property->id, 'deactivate'] ) }}">
                                {{ trans('cruds.property.fields.deactivate') }}
                            </a>
                            @endif
                            <form action="{{ route('admin.property.destroy', $property->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="12" class="text-center pgntion">{{ $properties->appends($filter)->appends(['filter_type'=>$filtertype, 'pr_type'=>$property_type])->links() }}</td>
                    </tr>
                </tfoot>
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
        // let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        // let deleteButton = {
        //     text: deleteButtonTrans,
        //     url: "{{ route('admin.property.massDestroy') }}",
        //     className: 'btn-danger',
        //     action: function(e, dt, node, config) {
        //         var ids = $.map(dt.rows({
        //             selected: true
        //         }).nodes(), function(entry) {
        //             return $(entry).data('entry-id')
        //         });

        //         if (ids.length === 0) {
        //             alert('{{ trans('global.datatables.zero_selected ') }}')

        //             return
        //         }

        //         if (confirm('{{ trans('global.areYouSure ') }}')) {
        //             $.ajax({
        //                     headers: {
        //                         'x-csrf-token': _token
        //                     },
        //                     method: 'POST',
        //                     url: config.url,
        //                     data: {
        //                         ids: ids,
        //                         _method: 'DELETE'
        //                     }
        //                 })
        //                 .done(function() {
        //                     location.reload()
        //                 })
        //         }
        //     }
        // }
        // dtButtons.push(deleteButton)

        // $.extend(true, $.fn.dataTable.defaults, {
        //     order: [
        //         [1, 'desc']
        //     ],
        //     pageLength: 100,
        // });
        // $('.datatable-User:not(.ajaxTable)').DataTable({
        //     buttons: dtButtons
        // })
        // $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        //     $($.fn.dataTable.tables(true)).DataTable()
        //         .columns.adjust();
        // });
    })
</script>
@endsection