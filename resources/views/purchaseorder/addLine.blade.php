@extends('base') @section('content')
<div class="container">
    @include('errors.form_errors') 
    
    {!! Form::open(['url' => action('PurchaseorderController@createPurchaseorderline', ['id' => $order->id]), 'autocomplete' => 'off']) !!}
    {!! Form::hidden('id', $order->id) !!}
    {!! Form::hidden('uuid', $order->uuid) !!}
    
    <div class="card">
        <div class="card-header">
            {{ trans('purchaseorder.addPurchaseorderlineTitle') }}
            <div class="btn-group pull-right">
                <a href="{{ Url::previous() }}" class="btn btn-secondary btn-xs">{!! config('ds.icons.pageBack') !!} {{ trans('general.pageBackWithoutSave') }}</a>
            </div>
        </div>
        <div class="card-body container-fluid card-form">
            <h2>{{ $order->orderNumber }}</h2>
            <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                        {!! Form::label('product_id', trans('purchaseorder.selectProductPlaceholer')) !!}
                        {!! Form::select('product_id', [] , null , ['class' => 'form-control selectProduct','required']) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('quantity', trans('purchaseorder.orderQuantity')) !!}
                        {!! Form::input('number', 'quantity', 1, ['class' => 'form-control', 'required']) !!}
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

    {!! Form::close() !!} 
@stop 
@section('footer')
<script>
$(function(){
    $('.selectProduct').select2({
        placeholder: '{{ trans("purchaseorder.selectProductPlaceholer") }}',
        theme: 'bootstrap',
        minimumInputLength: 1,
        ajax: {
            url: '{{ url("ajax/product") }}',
            method: 'post',
            dataType: 'json',
            delay: 100,
            cache: false,
            data: function (params) {
                return {
                    customer: '{{ $order->customer_id }}', 
                    order: '{{ $order->id }}', 
                    product: params.term, 
                }
            },
            processResults: function (data, page) {
                return {
                    results: data.results
                }
            }
        },
        templateResult: function formatState (row) {
            if(row.name){
                return $(
                    '<div class="row">' +
                        '<div class="col-md-2">' +
                            '<img src="' + ( row.thumbnail ? row.thumbnail : '{{ LAZY }}' ) + '" class="img-rounded img-thumb" />' +
                        '</div>' + 
                        '<div class="col-md-4">' + row.sku + '</div>' + 
                        '<div class="col-md-5">' + row.name + '</div>' +
                        '<div class="col-md-1 pull-right">' + row.qtyAvailable + '</div>' +
                    '</div>'
                );
            }
        }
    });      
});    
</script>
@stop