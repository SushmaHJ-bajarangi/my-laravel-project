<!-- Customer Id Field -->
<div class="form-group">
    {!! Form::label('customer_id', 'Customer:') !!}
    <p>{{ $customerProducts->getCustomer->name }}</p>
</div>

<!-- Model Id Field -->
<div class="form-group">
    {!! Form::label('model_id', 'Model:') !!}
    <p>{{ $customerProducts->getModel->title }}</p>
</div>

<!-- Door Field -->
<div class="form-group">
    {!! Form::label('door', 'Door:') !!}
    <p>{{ $customerProducts->door }}</p>
</div>

<!-- Number Of Floors Field -->
<div class="form-group">
    {!! Form::label('number_of_floors', 'Number Of Floors:') !!}
    <p>{{ $customerProducts->number_of_floors }}</p>
</div>

<!-- Cop Type Field -->
<div class="form-group">
    {!! Form::label('cop_type', 'COP Type:') !!}
    <p>{{ $customerProducts->cop_type }}</p>
</div>

<!-- Lop Type Field -->
<div class="form-group">
    {!! Form::label('lop_type', 'LOP Type:') !!}
    <p>{{ $customerProducts->lop_type }}</p>
</div>

<!-- Passenger Capacity Field -->
<div class="form-group">
    {!! Form::label('passenger_capacity', 'Passenger Capacity:') !!}
    <p>{{ $customerProducts->passenger_capacity }}</p>
</div>

<!-- Distance Field -->
<div class="form-group">
    {!! Form::label('distance', 'Distance:') !!}
    <p>{{ $customerProducts->distance }}</p>
</div>

<!-- Unique Job Number Field -->
<div class="form-group">
    {!! Form::label('unique_job_number', 'Unique Job Number:') !!}
    <p>{{ $customerProducts->unique_job_number }}</p>
</div>

<!-- Warranty Start Date Field -->
<div class="form-group">
    {!! Form::label('warranty_start_date', 'Start Date:') !!}
    <p>@if(isset($customerProducts->warranty_start_date)) {{ $customerProducts->warranty_start_date }} @else NO DATE @endif</p>
</div>

<!-- Warranty End Date Field -->
<div class="form-group">
    {!! Form::label('warranty_end_date', 'End Date:') !!}
    <p>@if(isset($customerProducts->warranty_end_date)) {{ $customerProducts->warranty_end_date }} @else NO DATE @endif</p>
</div>

<div class="form-group">
    {!! Form::label('no_of_services', 'Number Of Services:') !!}
    <p>{{ $customerProducts->no_of_services }}</p>
</div>

<div class="form-group">
    {!! Form::label('address', 'Address:') !!}
    <p>{{ $customerProducts->address }}</p>
</div>

<div class="form-group">
    {!! Form::label('zone', 'Zone:') !!}
    <p>{{ $customerProducts->zone }}</p>
</div>

<div class="form-group">
    {!! Form::label('project_name', 'Project Name:') !!}
    <p>{{ $customerProducts->project_name }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $customerProducts->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $customerProducts->updated_at }}</p>
</div>

