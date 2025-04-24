@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Passenger Capacity
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($passengerCapacity, ['route' => ['passengerCapacities.update', $passengerCapacity->id], 'method' => 'patch','id'=>'passenger']) !!}

                        @include('passenger_capacities.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection