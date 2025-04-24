
<div class="table-responsive">
    <table class="table display" id="example" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Place </th>
                <th>Jobs</th>
                <th>Customer Name </th>
                <th>Controller </th>
                <th>Controller Readiness Status</th>
                <th>Controller Readiness Date </th>
{{--                <th>COP / LOP </th>--}}
{{--                <th>COP / LOP Readiness Status </th>--}}
{{--                <th>COP / LOP Readiness Date</th>--}}
{{--                <th>Harness </th>--}}
{{--                <th>Harness Readiness Status</th>--}}
{{--                <th>Harness Readiness Date</th>--}}
                <th>Comments</th>
                <th>Specification</th>
                <th>Issue</th>
                <th>Adress Details </th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
            <tr>
                <td>{{ $item->place }}</td>
                <td>{{ $item->jobs }}</td>
                <?php $customer = \App\Models\customers::where('id', $item->customer_name)->first() ?>
                <td>{{ $customer->name ?? '-' }}</td>
                <td>{{ $item->controller }}</td>
                <td>{{ $item->controller_readiness_status }}</td>
                <td>{{ $item->controller_readiness_date }}</td>
{{--                <td>{{ $item->cop_lop }}</td>--}}
{{--                <td>{{ $item->cop_lop_readiness_status }}</td>--}}
{{--                <td>{{ $item->cop_lop_readiness_date }}</td>--}}
{{--                <td>{{ $item->harness }}</td>--}}
{{--                <td>{{ $item->harness_readiness_status }}</td>--}}
{{--                <td>{{ $item->harness_readiness_date }}</td>--}}
                <td>{{ $item->comments }}</td>
                <td>{{ $item->specification }}</td>
                <td>{{ $item->issue }}</td>
                <td>{{ $item->address }}</td>
                <td class="text-center">
                    <div class='btn-group'>

                        <form action="{{url('manufacture/delete/'.$item->id)}}" method="POST">
                            @csrf
                            <a href="{{url('manufacture/edit/'.$item->id)}}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                            <!-- Add other form inputs here -->
                            <button type="submit"  class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?')"><i class="glyphicon glyphicon-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

