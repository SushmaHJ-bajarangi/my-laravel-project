
@extends('layouts.app')
@section('content')

    <section class="content-header">
        <h1>
            Production Status - Factory Create
        </h1>
    </section>

    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <form method="post" action="{{url('manufacture/store')}}">
                        @csrf
                        <div class="form-group col-sm-6">
                            <label for="place">Place:</label>
                            <input class="form-control" id="place" name="place" type="text">
                            @error('place')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="jobs">Jobs:</label>
                            <input class="form-control" id="jobs" name="jobs" type="text">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Customer Name</label>
                            <select class="form-control" name="customer_name" id="customer_name">
                                <option selected disabled>Select Customer</option>
                                @if(isset($customer) && count($customer) > 0)
                                @foreach($customer as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="controller">Controller:</label>
                            <input class="form-control" id="controller" name="controller" type="text">
                            @error('controller')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label for="controller_readiness_status ">Controller Readiness Status :</label>
                            <input class="form-control" id="controller_readiness_status" name="controller_readiness_status" type="text">
                            @error('controller_readiness_status')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label for="controller_readiness_date">Controller Readiness Date :</label>
                            <input class="form-control" id="controller_readiness_date" name="controller_readiness_date" type="date">
                            @error('controller_readiness_date')<span class="text-danger">{{ $message }}</span>@enderror
                            <hr>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="manufacturing_stage_lot">Lop/cop:</label>
                            <div class="row man_stage_append">
                                <div class="man_stages_list">
                                    <div class="form-group col-sm-4">
                                        <label for="cop_lop ">COP / LOP:</label>
                                        <input class="form-control" id="cop_lop" name="cop_lop[]" type="text" >
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="cop_lop_readiness_status ">COP / LOP Readiness Status:</label>
                                        <input class="form-control" id="cop_lop_readiness_status" name="cop_lop_readiness_status[]" type="text">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="cop_lop_readiness_date">COP / LOP Readiness Date:</label>
                                        <input class="form-control" id="cop_lop_readiness_date" name="cop_lop_readiness_date[]" type="date">
                                    </div>
                                    <div class="form-group col-sm-1 mt-4">
                                        <button type="button" onclick="addManStageLot()"><i class="glyphicon glyphicon-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            @error('cop_lop.*')<span class="text-danger">{{ $message }}</span>@enderror
                            @error('cop_lop_readiness_status.*')<span class="text-danger">{{ $message }}</span>@enderror
                            @error('cop_lop_readiness_date.*')<span class="text-danger">{{ $message }}</span>@enderror
                            <hr>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="">Harness:</label>
                            <div class="stage_of_material">
                                <div class="som_list">
                                    <div class="form-group col-sm-4">
                                        <label for="harness ">Harness :</label>
                                        <input class="form-control" id="harness" name="harness[]" type="text" >
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="harness_readiness_status">Harness Readiness Status:</label>
                                        <input class="form-control" id="harness_readiness_status" name="harness_readiness_status[]" type="text" >
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="harness_readiness_date">Harness Readiness Date:</label>
                                        <input class="form-control" id="harness_readiness_date" name="harness_readiness_date[]" type="date">
                                    </div>
                                    <div class="form-group col-sm-1">
                                        <button type="button" onclick="add_som()"><i class="glyphicon glyphicon-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            @error('harness.*')<span class="text-danger">{{ $message }}</span>@enderror
                            @error('harness_readiness_status.*')<span class="text-danger">{{ $message }}</span>@enderror
                            @error('harness_readiness_date.*')<span class="text-danger">{{ $message }}</span>@enderror
                            <hr>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="comments ">Comments:</label>
                            <input class="form-control" id="comments" name="comments" type="text">
                            @error('comments')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="specification">Specification:</label>
                            <input class="form-control" id="specification" name="specification" type="text">
                            @error('specification')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="issue ">Issue:</label>
                            <textarea class="form-control" id="issue" name="issue" cols="50" rows="10"></textarea>
                            @error('issue')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="address">Address Details :</label>
                            <textarea class="form-control" id="address" name="address" cols="50" rows="10"></textarea>
                            @error('address')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            <button class="btn btn-primary" type="submit">Add</button>
                            <a href= {{url('manufacture')}} class="btn btn-default">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script type="application/javascript">
    function addManStageLot() {
        var uniqueId = makeid(5);
        $(".man_stage_append").append(`
        <div class="man_stages_list_${uniqueId}">
            <div class="form-group col-sm-4">
                <input type="text" name="cop_lop[]" class="form-control">
            </div>
            <div class="form-group col-sm-3">
                <input type="text" name="cop_lop_readiness_status[]" class="form-control">
            </div>
            <div class="form-group col-sm-3">
                <input type="date" name="cop_lop_readiness_date[]" class="form-control">
            </div>
            <div class="form-group col-sm-2">
                <button type="button" onclick="removeManStageLot('${uniqueId}')"><i class="glyphicon glyphicon-trash"></i></button>
            </div>
        </div>
    `);
    }

    function add_som() {
        var uniqueId = makeid(5);
        $(".stage_of_material").append(`
        <div class="som_list_${uniqueId}">
            <div class="form-group col-sm-4">
                <input class="form-control" id="harness" name="harness[]" type="text">
            </div>
            <div class="form-group col-sm-3">
                <input class="form-control" id="harness_readiness_status" name="harness_readiness_status[]" type="text">
            </div>
            <div class="form-group col-sm-3">
                <input class="form-control" id="harness_readiness_date" name="harness_readiness_date[]" type="date">
            </div>
            <div class="form-group col-sm-1">
                <button type="button" onclick="remove_som('${uniqueId}')"><i class="glyphicon glyphicon-trash"></i></button>
            </div>
        </div>
    `);
    }


    function makeid(length) {
        let result = '';
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        const charactersLength = characters.length;
        let counter = 0;
        while (counter < length) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
            counter += 1;
        }
        return result;
    }

    function removeManStageLot(id) {
        $(".man_stages_list_"+id).remove();
    }

    function remove_som(id) {
        $(".som_list_"+id).remove();
    }

</script>

@endsection
