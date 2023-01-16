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
                    @foreach($queries as $key => $query)
                    <tr data-entry-id="{{ $query->id }}">
                        <td>
                            {{ $query->id ?? '' }}
                        </td>
                        <td>
                            <a href="{{ route('admin.users.show', $query->fromuser->id ?? '') }}">
                                {{ $query->fromuser->name ?? '' }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.property.show', $query->property->id ?? '') }}">
                                {{ $query->property->address ?? '' }}
                            </a>
                        </td>
                        <td>
                            @if(empty($query->assistant))
                            <button type="button" class="btn btn-xs btn-info openmodel" data-prid="{{$query->property->id ?? ''}}" data-id="{{$query->id}}">Assign assistant</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                <tfoot>
                    <tr>
                        <td colspan="6">{{ $queries->links() }}</td>
                    </tr>
                </tfoot>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="assistantmodel" class="modal fade" role="dialog">
    <div class="modal-dialog">
        
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Assign Assistant</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="assis_form">
                @csrf
                    <input type="hidden" name="property_id" id="qproperty_id">
                    <input type="hidden" name="conversastion_id" id="conversastion_id">
                    <select name="user_id" id="assis_id">
                        @foreach($assistants as $assistant)
                        <option value="{{$assistant->id}}">{{ $assistant->name }}</option>
                        @endforeach
                    </select>
                    <input type="submit" name="assign" value="Assign" class="btn btn-default">
                </form>
            </div> 
        </div>

    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(document).ready(function() {
        $('.openmodel').click(function() {
            let con_id = $(this).data("id");
            let prop_id = $(this).data("prid")
            $("#qproperty_id").val(prop_id);
            $("#conversastion_id").val(con_id);
            $('#assistantmodel').modal('show');

        });
        $("#assis_form").submit(function(event) {   
            event.preventDefault();
            $.ajax({
        url: "{{route('admin.conversation.assignassistant') }}",
        type: 'post',
        data: $('form#assis_form').serialize(),
        success: function(response) {
                  console.log(response)
                  if(response.status==true){
                    window.location.reload();
                  }
                 }
    });
        });
    })
</script>
@endsection