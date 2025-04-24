@if (auth()->check())
    @if (auth()->user()->role == 1)
        {!! Form::open(['route' => ['customerProducts.destroy', $id], 'method' => 'delete']) !!}
        <div class='btn-group'>

            @if (in_array(strtolower($status), ['amc expire', 'expired']))
                <button type="button" class="btn btn-info btn-xs" style="width: 35px;" data-toggle="modal" data-target="#offerModal-{{ $id }}">
                    Offer
                </button>
            @endif

            <a href="{{ route('customerProducts.show', $id) }}" class='btn btn-default btn-xs'>
                <i class="glyphicon glyphicon-eye-open"></i>
            </a>

            <a href="{{ route('customerProducts.edit', $id) }}" class='btn btn-default btn-xs'>
                <i class="glyphicon glyphicon-edit"></i>
            </a>

            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
                'type' => 'submit',
                'class' => 'btn btn-danger btn-xs',
                'onclick' => "return confirm('Are you sure?')"
            ]) !!}

        </div>
        {!! Form::close() !!}

        <div class="modal fade" id="offerModal-{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="offerModalLabel-{{ $id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="offerModalLabel-{{ $id }}">Offer for Product {{ $id }}</h4>
                    </div>

                    <div class="modal-body">

                        <form action="{{ route('customerProducts.storeOffer', $id) }}" method="POST">
                            @csrf
                            @php
                                $now = \Carbon\Carbon::now();
                                $month = $now->format('M');
                                $year = $now->format('y');
                                $day = $now->format('d');

                                $customerProduct = \App\Models\customer_products::find($id);
                                $jobNo = $customerProduct->unique_job_number;

                                $status = $customerProduct->status ?? 'expired';
                                $statusSuffix = '';

                               if (strtolower($status) == 'expired') {
                                $statusSuffix = '/W';
                               } elseif (strtolower($status) == 'amc expired') {
                               $statusSuffix = '/A';
                               }
                              $offerNo = "{$month}-{$year}-{$day}-TEK-SR-{$jobNo}{$statusSuffix}";
                            @endphp

                            <div class="form-group col-md-12" style="margin-bottom:15px;">
                                <label>Offer Type:</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="offer_type" value="standard" checked> Standard
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="offer_type" value="non-standard"> Non-standard
                                </label>
                            </div>

                            <div class="form-group col-md-12" style="margin-bottom:15px;">
                                <label for="offer_date">Date:</label>
                                <input type="date" class="form-control" id="offer_date" name="offer_date" required>
                            </div>

                            <div class="form-group col-md-12" style="margin-bottom:15px;">
                                <label for="offer_no">Offer No:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="offer_no"
                                    name="offer_no"
                                    value="{{ $offerNo }}"
                                    readonly
                                    required>
                            </div>

                            <div class="form-group col-md-12" style="margin-bottom:15px;">
                                <label for="site_name">Site Name:</label>
                                <input type="text" class="form-control" id="site_name" name="site_name">
                            </div>

                            <div class="form-group col-md-12" style="margin-bottom:15px;">
                                <label for="address">Address:</label>
                                <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @else
        <th></th>
    @endif

@endif

