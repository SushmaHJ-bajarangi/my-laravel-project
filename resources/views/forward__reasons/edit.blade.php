@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Forward  Reason
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($forwardReason, ['route' => ['forwardReasons.update', $forwardReason->id], 'method' => 'patch','id'=>'forwardreason']) !!}

                        @include('forward__reasons.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection