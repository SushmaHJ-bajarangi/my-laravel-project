@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Edit
        </h1>
    </section>

    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <form method="post" action="{{ url('manufacture/update/'.$data->id) }}">
                        @csrf

                        <div class="form-group col-sm-6">
                            <label for="place">Place:</label>
                            <input class="form-control" id="place" name="place" type="text" value="{{ old('place', $data->place) }}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="jobs">Jobs:</label>
                            <input class="form-control" id="jobs" name="jobs" type="text" value="{{ old('jobs', $data->jobs) }}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Customer Name</label>
                            <select class="form-control" name="customer_name" id="customer_name">
                                <option selected disabled>Select Customer</option>
                                @if(isset($customer) && count($customer) > 0)
                                    @foreach($customer as $item)
                                        <option value="{{ $item->id }}" {{ $data->customer_name == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="controller">Controller:</label>
                            <input class="form-control" id="controller" name="controller" type="text" value="{{ old('controller', $data->controller) }}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="controller_readiness_status">Controller Readiness Status:</label>
                            <input class="form-control" id="controller_readiness_status" name="controller_readiness_status" type="text" value="{{ old('controller_readiness_status', $data->controller_readiness_status) }}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="controller_readiness_date">Controller Readiness Date:</label>
                            <input class="form-control" id="controller_readiness_date" name="controller_readiness_date" type="date" value="{{ old('controller_readiness_date', $data->controller_readiness_date) }}">
                            <hr>
                        </div>

                        <div class="form-group col-sm-12">
                            <hr>
                            <label>Lop/cop:</label>
                            <div class="man_stage_append">
                                @if(isset($p_mns) && count($p_mns) > 0)
                                    @foreach($p_mns as $a => $b)
                                        <div class="man_stages_list_{{ $b->id }}">
                                            <div class="form-group col-sm-4">
                                                @if($a == 0)<label for="cop_lop">COP / LOP:</label> @endif
                                                <input class="form-control" id="cop_lop" name="cop_lop[]" value="{{ old('cop_lop.' . $a, $b->cop_lop) }}" type="text">
                                            </div>
                                            <div class="form-group col-sm-3">
                                                @if($a == 0)<label for="cop_lop_readiness_status">COP / LOP Readiness Status:</label> @endif
                                                <input class="form-control" id="cop_lop_readiness_status" name="cop_lop_readiness_status[]" value="{{ old('cop_lop_readiness_status.' . $a, $b->cop_lop_readiness_status) }}" type="text">
                                            </div>
                                            <div class="form-group col-sm-3">
                                                @if($a == 0)<label for="cop_lop_readiness_date">COP / LOP Readiness Date:</label> @endif
                                                <input class="form-control" id="cop_lop_readiness_date" name="cop_lop_readiness_date[]" value="{{ old('cop_lop_readiness_date.' . $a, $b->cop_lop_readiness_date) }}" type="date">
                                            </div>
                                            @if($a == 0)
                                                <div class="form-group col-sm-1 mt-4">
                                                    <button type="button" onclick="addManStageLot()"><i class="glyphicon glyphicon-plus"></i></button>
                                                </div>
                                            @else
                                                <div class="form-group col-sm-1">
<!--                                                    <button type="button" onclick="removeManStageLot({{ $b->id }})"><i class="glyphicon glyphicon-trash"></i></button>-->
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="man_stage_append">
                                        <div class="man_stages_list">
                                            <div class="form-group col-sm-4">
                                                <label for="cop_lop">COP / LOP:</label>
                                                <input class="form-control" id="cop_lop" name="cop_lop[]" type="text">
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="cop_lop_readiness_status">COP / LOP Readiness Status:</label>
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
                                @endif
                            </div>
                            <hr>
                        </div>

                        <div class="form-group col-sm-12">
                            <label>Harness:</label>
                            <div class="stage_of_material">
                                @if(isset($p_som) && count($p_som) > 0)
                                    @foreach($p_som as $key => $item)
                                        <div class="som_list_{{ $item->id }}">
                                            <div class="form-group col-sm-4">
                                                @if($key == 0) <label for="harness">Harness:</label>@endif
                                                <input class="form-control" id="harness" name="harness[]" value="{{ old('harness.' . $key, $item->harness) }}" type="text" required>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                @if($key == 0)<label for="harness_readiness_status">Harness Readiness Status:</label>@endif
                                                <input class="form-control" id="harness_readiness_status" name="harness_readiness_status[]" value="{{ old('harness_readiness_status.' . $key, $item->harness_readiness_status) }}" type="text" required>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                @if($key == 0)<label for="harness_readiness_date">Harness Readiness Date:</label>@endif
                                                <input class="form-control" id="harness_readiness_date" name="harness_readiness_date[]" value="{{ old('harness_readiness_date.' . $key, $item->harness_readiness_date) }}" type="date" required>
                                            </div>
                                            @if($key == 0)
                                                <div class="form-group col-sm-1">
                                                    <button type="button" onclick="add_som()"><i class="glyphicon glyphicon-plus"></i></button>
                                                </div>
                                            @else
                                                <div class="form-group col-sm-1">
<!--                                                    <button type="button" onclick="remove_som({{ $item->id }})"><i class="glyphicon glyphicon-trash"></i></button>-->
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="som_list">
                                        <div class="form-group col-sm-4">
                                            <label for="harness">Harness:</label>
                                            <input class="form-control" id="harness" name="harness[]" type="text" required>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="harness_readiness_status">Harness Readiness Status:</label>
                                            <input class="form-control" id="harness_readiness_status" name="harness_readiness_status[]" type="text" required>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="harness_readiness_date">Harness Readiness Date:</label>
                                            <input class="form-control" id="harness_readiness_date" name="harness_readiness_date[]" type="date" required>
                                        </div>
                                        <div class="form-group col-sm-1">
                                            <button type="button" onclick="add_som()"><i class="glyphicon glyphicon-plus"></i></button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <hr>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="comments">Comments:</label>
                            <input class="form-control" id="comments" name="comments" type="text" value="{{ old('comments', $data->comments) }}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="specification">Specification:</label>
                            <input class="form-control" id="specification" name="specification" type="text" value="{{ old('specification', $data->specification) }}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="issue">Issue:</label>
                            <textarea class="form-control" id="issue" name="issue" cols="50" rows="10">{{ old('issue', $data->issue) }}</textarea>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="address">Address Details:</label>
                            <textarea class="form-control" id="address_" name="address" cols="50" rows="10">{{ old('address', $data->address) }}</textarea>
                        </div>

                        <div class="form-group col-sm-12">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a href="{{ url('manufacture') }}" class="btn btn-default">Cancel</a>
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
                </div>
            `);
        }

        function add_som() {
            var uniqueId = makeid(5);
            $(".stage_of_material").append(`
                <div class="som_list_${uniqueId}">
                    <div class="form-group col-sm-4">
                        <input class="form-control" name="harness[]" type="text">
                    </div>
                    <div class="form-group col-sm-3">
                        <input class="form-control" name="harness_readiness_status[]" type="text">
                    </div>
                    <div class="form-group col-sm-3">
                        <input class="form-control" name="harness_readiness_date[]" type="date">
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
            $(".man_stages_list_" + id).remove();
        }

        function remove_som(id) {
            $(".som_list_" + id).remove();
        }
    </script>
@endsection
