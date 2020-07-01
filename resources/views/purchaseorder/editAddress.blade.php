@extends('base') @section('content')
<div class="container">
    @include('errors.form_errors') 
    
    
    {!! Form::model($order,['method' => 'PATCH' , 'url' => 'salesorder/' . $order->id . '/edit/address','autocomplete' => 'off']) !!}
    {!! Form::hidden('id', $order->id) !!}
    {!! Form::hidden('uuid', $order->uuid) !!}
    
    <div class="card">
        <div class="card-header">
            {{ trans('salesorder.editAddressFormStep1') }}
            <div class="btn-group pull-right">
                <a href="{{ url('/salesorder/' . $order->id ) }}" class="btn btn-secondary btn-xs">{!! config('ds.icons.pageBack') !!} {{ trans('general.pageBackWithoutSave') }}</a>
            </div>
        </div>
        <div class="card-body container-fluid card-form">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('firstName', trans('salesorder.firstName')) !!}
                        {!! Form::text('firstName', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('lastName', trans('salesorder.lastName')) !!}
                        {!! Form::text('lastName', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('companyName', trans('salesorder.companyName')) !!}
                        {!! Form::text('companyName', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('telephone', trans('salesorder.telephone')) !!}
                        {!! Form::text('telephone', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('email', trans('salesorder.email')) !!}
                        {!! Form::email('email', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            {{ trans('salesorder.editAddressFormStep1') }}
        </div>
        <div class="card-body container-fluid card-form">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('postcode', trans('salesorder.postcode')) !!}
                        {!! Form::text('postcode', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('number', trans('salesorder.number')) !!}
                        {!! Form::text('number', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('street', trans('salesorder.street')) !!}
                        {!! Form::text('street', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('city', trans('salesorder.city')) !!}
                        {!! Form::text('city', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('street2', trans('salesorder.street2')) !!}
                        {!! Form::text('street2', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('region', trans('salesorder.region')) !!}
                        {!! Form::text('region', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('country', trans('salesorder.country')) !!}
                        {!! Form::select('country',trans('countries'), null, ['class' => 'form-control select2-selectCountry']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::submit(trans('general.createSubmit'), ['class' => 'btn btn-primary form-control']) !!}
            </div>
        </div>
    </div>

    {!! Form::close() !!} @stop @section('footer')
    <script>
        $(function () {
            $.autoPostcode({
                url: "{{ url('/ajax/postcode') }}",
                blur: '#number',
                postcode: '#postcode',
                housenumber: '#number',
                city: '#city',
                street: '#street',
                region: '#region',
                country: '#country'
            });
        });
    </script>
    @stop