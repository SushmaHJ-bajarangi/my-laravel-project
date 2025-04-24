@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Product Status
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($productStatus, ['route' => ['productStatuses.update', $productStatus->id], 'method' => 'patch','id'=>'productStatus']) !!}

                        @include('product_statuses.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection