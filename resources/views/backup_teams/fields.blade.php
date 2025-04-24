<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control','id'=>'title']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','id'=>'name']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control','id'=>'email']) !!}
</div>

<!-- Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('number', 'Number:') !!}
    {!! Form::text('contact_number', null, ['class' => 'form-control','id'=>'number']) !!}
</div>

<!-- Zone Field -->
<div class="form-group col-sm-6">
    <label>Zone</label>
    <select class="form-control" name="zone" id="zone">
        <option selected disabled>Select Zone</option>
        @if(isset($customer_zones) && count($customer_zones) > 0)
            @foreach($customer_zones as $customer_zone)
                <option @if(isset($backupTeam) && $backupTeam->zone == $customer_zone->id) selected @endif  value="{{$customer_zone->id}}">{{$customer_zone->title}}</option>
            @endforeach
        @endif
    </select>
</div>

<div class="clearfix"></div>
<div class="form-group col-sm-12">
    <h4><b>Helpers</b></h4>
</div>
@if(isset($helpers) && count($helpers) > 0)
    @foreach($helpers as $helper)
        <div class="remove_{{$helper->id}}">
            <div class="form-group col-sm-5">
                <label>Name</label>
                <input class="form-control" name="helper_name[]" type="text" value="{{$helper->name}}">
            </div>
            <div class="form-group col-sm-5">
                <label>Contact Number</label>
                <input class="form-control contact_number" name="helper_contact_number[]" type="text" value="{{$helper->number}}" id="contact_number" maxlength="10">
            </div>
            <div class="form-group col-sm-2">
                <button type="button" style="margin-top: 23px" class="btn btn-danger" onclick="removeHelper('{{$helper->id}}')">Remove</button>
            </div>
            <input class="form-control" name="helper_id[]" type="hidden" value="{{$helper->id}}">
        </div>
    @endforeach
@endif
<div id="dynamic_field"></div>
<div class="form-group col-sm-5">
    <label>Name</label>
    <input class="form-control" name="helper_name[]" type="text">
</div>
<div class="form-group col-sm-5">
    <label>Contact Number</label>
    <input class="form-control contact_number" name="helper_contact_number[]" type="text" id="helper_contact_number" maxlength="10">
</div>
<div class="form-group col-sm-2">
    <button type="button" style="margin-top: 23px" id="add" class="btn btn-info">Add Helpers</button>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::button('Save', ['class' => 'btn btn-primary','onclick' => 'teamSubmit()']) !!}
    <a href="{{ route('backupTeams.index') }}" class="btn btn-default">Cancel</a>
</div>


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            var i = 1;
            $("#add").click(function(){
                i++;
                $('#dynamic_field').append('<div id="row'+i+'"><div class="form-group col-sm-5">\n' +
                    '    <label>Name</label>\n' +
                    '    <input class="form-control" name="helper_name[]" type="text">\n' +
                    '</div>\n' +
                    '<div class="form-group col-sm-5">\n' +
                    '    <label>Contact Number</label>\n' +
                    '    <input class="form-control" name="helper_contact_number[]" type="text" maxlength="10">\n' +
                    '</div>\n' +
                    '<div class="form-group col-sm-2">\n' +
                    '    <button type="button" id="'+i+'" style="margin-top: 23px" class="btn btn-danger btn_remove">Remove</button>\n' +
                    '</div></div>');
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id");
                $('#row'+button_id+'').remove();
            })
        });


        function teamSubmit(){
            var title = $('#title').val();
            var team_id = $('#team_id').val();
            var name = $('#name').val();
            var email = $('#email').val();
            var contact_number = $('#number').val();
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if(title == '' || title.length <= 0){
                toastr.clear();
                toastr.error('Title Required');
            }
            else if(name == '' || name.length <= 0){
                toastr.clear();
                toastr.error('Name Required');

            }
            else if(email == '' || email.length <= 0){
                toastr.clear();
                toastr.error('Email Required');
            }
            else if(!regex.test(email)){
                toastr.clear();
                toastr.error('Enter Valid Email');
            }

            else if(number == '' || number.length <= 0){
                toastr.clear();
                toastr.error('Contact Number Required');
            }
            else{
                $.ajax({
                    url: '{{url('backUpcheckTeamNumber')}}',
                    type: 'post',
                    data: {'contact_number':contact_number,'team_id':team_id,'_token':'{{csrf_token()}}'},
                    datatype: 'JSON',
                    success: function (response) {
                        if(response == 'number_exists')
                        {
                            toastr.error('Team With Same Contact Number Already Exists');
                            return false;
                        }
                        else {
                            $('#team-form').submit();
                        }
                    },
                    error:function (e) {
                        console.log(e);
                    }
                });
            }
        }




        // {{--    check contact number for team members--}}


        // helper remove
        function removeHelper(id){
            $.ajax({
                url: '{{url('backUpremoveHelper')}}',
                type: 'post',
                data: {'id':id,'_token':'{{csrf_token()}}'},
                beforeSend:function(){
                    return confirm("Are you sure?");
                },
                success: function (response) {
                    if(response == 'success'){
                        $('.remove_'+id).remove();
                        toastr.success('Helper deleted successfully')
                    }
                }
            });

        }
        // helper remove

    </script>
@endsection

