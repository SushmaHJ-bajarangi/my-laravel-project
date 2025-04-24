@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Ticket Reports</h1>
    </section>
 <div>
     <div class="content">
         <div class="clearfix"></div>
         <div class="box box-primary">
             <div class="box-body">
                 <div class="col-sm-6">
                     <label>Days</label>
                     <select class="form-control select" name="days">
                         <option value="1">1</option>
                         <option value="2">2</option>
                         <option value="3">3</option>
                         <option value="4">4</option>
                         <option value="5">5</option>
                         <option value="6">6</option>
                         <option value="7">7</option>
                         <option value="8">8</option>
                         <option value="9">9</option>
                         <option value="10">10</option>
                         <option value="11">11</option>
                         <option value="12">12</option>
                         <option value="13">13</option>
                         <option value="14">14</option>
                         <option value="15">15</option>
                         <option value="16">16</option>
                         <option value="17">17</option>
                         <option value="18">18</option>
                         <option value="19">19</option>
                     </select>
                 </div>
             </div>
         </div>
     </div>
 </div>
@endsection
@section('scripts')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $('select').on('click', function() {
            var  days = $('.select').val();
            $.ajax({
                url: "{{ url('Reports') }}",
                type: "POST",
                data: {'days': days, _token: '{{ csrf_token() }}'},
                success: function (data){
                console.log(data);
//              $('.table-bordered').
//                 product
//                     $('#product_data').html(data);
                }
            });
        });
    </script>

    @endsection