@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Service List
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($servicesList, ['route' => ['servicesLists.update', $servicesList->id], 'method' => 'patch','id'=>'service_lists']) !!}

                        @include('services_lists.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection