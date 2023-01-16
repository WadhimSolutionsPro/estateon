@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.property.title') }}
    </div>
    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.id') }}
                        </th>
                        <td>
                            {{ $data['property']->id }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            Name
                        </th>
                        <td>
                            {{ $data['property']->name }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            Type
                        </th>
                        <td>
                            {{ ucfirst($data['property']->type) }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.description') }}
                        </th>
                        <td>
                            {{ $data['property']->description }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.address') }}
                        </th>
                        <td>
                            {{ $data['property']->address }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            Furnished
                        </th>
                        <td>
                            {{ ucfirst($data['property']->property_details['furnished']) }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.featured') }}
                        </th>
                        <td>
                            {{ $data['property']->featured==1 ? 'true': 'false' }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.hot') }}
                        </th>
                        <td>
                            {{ $data['property']->hot == 1 ? 'true': 'false' }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.amenities') }}
                        </th>
                        <td>
                            @foreach($data['property']->amenities as $amenity)
                            <span class="badge badge-info">{{$amenity['amenity_data']['name'] ?? ''}}</span>
                            @endforeach
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.vastu') }}
                        </th>
                        <td>
                            <span class="badge badge-info">{{ $data['property']->vastu['vastu_data']['name']  ?? ''}}</span>
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.preferences') }}
                        </th>
                        <td>
                            @foreach($data['property']->preferences as $preference)
                            <span class="badge badge-info">{{ $preference['preferences_data']['name']  ?? ''}}</span>
                            @endforeach
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.property_type') }}
                        </th>
                        <td>
                            {{ $data['property']->property_type['type_data']['name']  ?? '' }}
                        </td>
                    </tr>

                    <!-- <tr>
                        <th>
                            {{ trans('cruds.property.fields.bedroom') }}
                        </th>
                        <td>
                            {{ $data['property']['property_details']->bedroom }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.bathroom') }}
                        </th>
                        <td>
                            {{ $data['property']['property_details']->bathroom }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.balcony') }}
                        </th>
                        <td>
                            {{ $data['property']['property_details']->balcony }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.kitchen') }}
                        </th>
                        <td>
                            {{ $data['property']['property_details']->kitchen }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.living_room') }}
                        </th>
                        <td>
                            {{ $data['property']['property_details']->living_room == 1 ? 'true' :'false' }}
                        </td>
                    </tr> -->

                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.furnished') }}
                        </th>
                        <td>
                            @switch($data['property']['property_details']->furnished)
                            @case('unfurnished')
                            <span> Un frinished</span>
                            @break

                            @case('furnished')
                            <span>Furnished</span>
                            @break
                            @case('semi_furnished')
                            <span>Semi Furnished</span>
                            @break
                            @endswitch
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.price') }}
                        </th>
                        <td>
                            {{ $data['property']['property_details']->price }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            Size
                        </th>
                        <td>
                            {{ $data['property']['property_details']->size }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            Length
                        </th>
                        <td>
                            {{ $data['property']['property_details']->length }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            Width
                        </th>
                        <td>
                            {{ $data['property']['property_details']->length }}
                        </td>
                    </tr>
                    
                    <tr>
                        <th>
                        Property Category
                        </th>
                        <td>
                        {{ $data['property']['property_details']->property_category }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                        Property Feature
                        </th>
                        <td>
                        {{ $data['property']['property_details']->property_feature }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                        Govt Tax Include
                        </th>
                        <td>
                        @if($data['property']['property_details']->govt_tax_include == 1)
                            Included                            
                        @elseif($data['property']['property_details']->govt_tax_include == 0)
                            Not included                            
                        @endif
                        </td>
                    </tr>

                    <tr>
                        <th>
                        Extra Notes
                        </th>
                        <td>
                        {{$data['property']['property_details']->extra_notes}}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.likes') }}
                        </th>
                        <td>
                            {{ $data['property']->likes_count }}
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