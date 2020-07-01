@extends('base') @section('content')
<div class="container">
    @include('errors.form_errors') 
    
    {!! Form::model($po, ['method' => 'PATCH' , 'url' => 'purchaseorders/' . $po->id . '/edit/details', 'autocomplete' => 'off']) !!}
    {!! Form::hidden('id', $po->id) !!}
    {!! Form::hidden('uuid', $po->uuid) !!}
    
    <div class="card">
        <div class="card-header">
            {{ trans('purchaseorder.editDetailsFormStep1') }}
            <div class="btn-group pull-right">
                <a href="{{ url('/purchaseorders/' . $po->id ) }}" class="btn btn-secondary btn-xs">{!! config('ds.icons.pageBack') !!} {{ trans('general.pageBackWithoutSave') }}</a>
            </div>
        </div>
        <div class="card-body container-fluid card-form">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('number', trans('purchaseorder.orderNumber')) !!}
                        {!! Form::text('number', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('expected_at', trans('purchaseorder.expected_at')) !!}
                        {!! Form::text('expected_at', $po->expected_at, ['class' => 'form-control datepicker']) !!}
                    </div>
                </div>
                @if(!$po->is_return)                 
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('trackandtrace', trans('purchaseorder.trackandtrace')) !!}
                            {!! Form::text('trackandtrace', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    @if(isset($po->supplier))
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('supplier_id', trans('purchaseorder.supplier')) !!}
                                {!! Form::select('supplier_id', $suppliers, $po->supplier->id, [
                                        'class' => 'form-control select2-selectCountry',
                                        'data-tags' => true,
                                        'data-placeholder' => trans('general.selectAnOption'), 
                                ]) !!}
                            </div>
                        </div>
                    @endif
                @else
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('trackandtrace', trans('purchaseorder.trackandtrace')) !!}
                            {!! Form::text('trackandtrace', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                @endif                
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

    {!! Form::close() !!} 
@stop 
    