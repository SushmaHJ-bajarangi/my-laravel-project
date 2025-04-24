@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Part
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($parts, ['route' => ['parts.update', $parts->id], 'method' => 'patch','id'=>'parts-form']) !!}

                        @include('parts.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection