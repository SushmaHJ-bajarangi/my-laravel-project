@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Customer Project
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'customerProducts.store','id' => 'customer-product-form']) !!}
                    <input type="hidden" name="id" id="customer_product_id" value="">
                        @include('customer_products.fields')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
