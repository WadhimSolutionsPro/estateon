@extends('layouts.admin')
@section('content')
<!-- <div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route("adminuser.property.create") }}">
            {{ trans('global.add') }} {{ trans('cruds.property.title_singular') }}
        </a>
    </div>
</div> -->
<div class="card">
    <div class="card-header">
        <h3>{{ trans('cruds.property.title_singular') }} {{ trans('global.list') }}</h3>
    </div>
    <div class="card-body">
        <div class="filter-area in-flx">
            <div class="card-tools">
                <h4>Filter</h4>
            </div>
            <form action="{{ route('adminuser.property.index') }}" class="filter-item">
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
                        <th>
                            {{ trans('cruds.property.fields.property_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.featured') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.hot') }}
                        </th>
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
                        <td>
                            <span class="badge badge-info">{{ $property->property_type['type_data']['name']  ?? ''}}</span>

                        </td>
                        <td>
                            {{ $property->featured==1 ? 'true':'false' }}
                        </td>
                        <td>
                            {{ $property->hot==1 ? 'true':'false' }}
                        </td>
                        <td> 
                            <div class="activation_button">
                            <a class="btn btn-xs btn-primary" href="{{ route('adminuser.property.show', $property->id) }}">
                                {{ trans('global.view') }}
                            </a>

                            <a class="btn btn-xs btn-info" href="{{ route('adminuser.property.edit', $property->id) }}">
                                {{ trans('global.edit') }}
                            </a>
                            </div>
                            <div>
                            <a class="btn btn-xs btn-info" href="{{ route('adminuser.property.image', $property->id) }}">
                                {{ trans('cruds.property.fields.image') }}
                            </a>
                            
                            </div> 
                            
                            <form action="{{ route('adminuser.property.destroy', $property->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

@endsection