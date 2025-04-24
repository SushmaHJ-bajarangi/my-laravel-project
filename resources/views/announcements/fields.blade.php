<!-- Title Field -->
<div class="form-group col-sm-3">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control','id'=>'title']) !!}
</div>

@if(isset($announcement) && !empty($announcement))
    <!-- Description Field -->
    <div class="form-group col-sm-9">
        {!! Form::label('description', 'Description:') !!}
        <input name="description" class="form-control" rows="5" value="{{$announcement->description}}" id="description"></input>
    </div>
@else
    <div class="form-group col-sm-9">
        {!! Form::label('description', 'Description:') !!}
        <input name="description" class="form-control" rows="5" id="description"></input>
    </div>
@endif


<div class="form-group col-sm-12">
    {!! Form::label('tecnician', 'Technician:') !!}
    <div class="clearfix"></div>
    <label class="radio-inline">
        <input type="radio" @if (isset($announcement) && $announcement->technician =='Customer' ) ? checked  @endif  name="technician" value="Customer">Customer
    </label>
    <label class="radio-inline">
        <input type="radio" @if (isset($announcement) &&  $announcement->technician =='Technician' ) ? checked  @endif  name="technician"  value="Technician">Technician
    </label>
    <br><br>
</div>

<!-- Image Field -->
    <div class="form-group col-sm-4">
        {!! Form::label('image', 'Image:') !!}
        <input name="image" type="file" class="form-control" id="image">
    </div>
<div class="form-group col-sm-8">
@if(isset($announcement) && $announcement->image !='')
    <img class="img-rounded" style="height: 100px;width:100px;" src="{{asset('/announce/'.$announcement->image)}}">
@endif
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::button('Save', ['class' => 'btn btn-primary','onclick' => 'announcementSubmit()']) !!}
    <a href="{{ route('announcements.index') }}" class="btn btn-default">Cancel</a>
</div>


<script>

    function announcementSubmit(){
        var title = $('#title').val();
        var image = $("#image").serialize();
        var technician = $('#technician').val();
        var description = $('#description').val();

        if(title = '' || title.length <= 0){
            toastr.clear();
            toastr.error('title Required');
        }
        else if(description = '' || description.length <= 0){
            toastr.clear();
            toastr.error('description Required');
        }
        else{
            $('#announcement').submit();
        }

    }
</script>