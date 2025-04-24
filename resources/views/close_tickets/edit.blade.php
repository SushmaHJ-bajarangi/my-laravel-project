@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Close Ticket
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($closeTicket, ['route' => ['closeTickets.update', $closeTicket->id], 'method' => 'patch','id'=>'close_Ticket']) !!}

                        @include('close_tickets.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection