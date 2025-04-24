@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Customer Problems
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($problems, ['route' => ['problems.update', $problems->id], 'method' => 'patch']) !!}

                        @include('problems.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection