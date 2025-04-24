@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Products Model
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'productsModels.store','id'=>'product_model']) !!}

                        @include('products_models.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
