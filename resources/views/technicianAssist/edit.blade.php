@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Technician  Assist
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($technicianAssist, ['route' =>['technicianAssists.update', $technicianAssist->id], 'method' => 'patch','files' => 'true','enctype'=>'multipart/form-data','id'=>'technician_form']) !!}

                        @include('technicianAssist.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection