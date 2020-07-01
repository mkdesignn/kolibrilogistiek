@extends('base')

    @section('content')
    <div class="container">
    @include('errors.form_errors')
        {!! Form::open(['action' => 'PurchaseorderController@store', 'autocomplete' => 'off']) !!}
        <div class="card">
            <div class="card-header">
                {{ trans('purchaseorder.createFormStep1') }}
                <div class="btn-group pull-right">
                    <a href="{{ PREVIOUS_URL }}" class="btn btn-secondary btn-xs">{!! config('ds.icons.pageBack') !!} {{ trans('general.pageBackWithoutSave') }}</a>
                </div>  
            </div>
            <div class="card-body container-fluid card-form">
                <div class="row">
@if(admin())                    
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('customer_id', trans('purchaseorder.customer')) !!}
                            {!! Form::select('customer_id', $customers, null, [
                                'id' => 'customer',
                                'data-placeholder' => trans('general.selectAnOption') , 
                                'data-url' => action('AjaxController@supplierOptionListByCustomer', ['customer' => null]), 
                                'data-target' => '#supplier', 
                                'data-tags' => true,
                                'class' => 'form-control select2-ajax-trigger'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::hidden('supplier_placeholder', null,[ 'id' => 'supplier_placeholder' ] ) !!}
                            {!! Form::hidden('supplier_parent', null,[ 'id' => 'supplier_parent' ]  ) !!}
                            {!! Form::label('supplier_id', trans('purchaseorder.supplier')) !!}
                            {!! Form::select('supplier_id', $suppliers, null, ['id' => 'supplier', 'data-placeholder' => trans('purchaseorder.selectFirstCustomer') ,'class' => 'form-control select2-selectMinimal']) !!}
                        </div>
                    </div>
@else
                    {!! Form::hidden('customer_id', Session::get('user')->customer_id, ['id' => 'customer']) !!}    
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::hidden('supplier_placeholder', null,[ 'id' => 'supplier_placeholder' ] ) !!}
                            {!! Form::hidden('supplier_parent', null,[ 'id' => 'supplier_parent' ]  ) !!}
                            {!! Form::label('supplier_id', trans('purchaseorder.supplier')) !!}
                            {!! Form::select('supplier_id', $suppliers, null, ['id' => 'supplier', 'data-tags' => 'true', 'data-placeholder' => trans('purchaseorder.selectFirstCustomer') ,'class' => 'form-control select2-selectCountry']) !!}
                        </div>
                    </div>
@endif   
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('number', trans('purchaseorder.orderNumber')) !!}
                            {!! Form::text('number', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('expected_at', trans('purchaseorder.expected_at')) !!}
                            {!! Form::text('expected_at', null, ['class' => 'form-control datepicker']) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('trackandtrace', trans('purchaseorder.trackandtrace')) !!}
                            {!! Form::text('trackandtrace', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                {{ trans('purchaseorder.createFormStep4') }}
                <span class="pull-right">
                    <a class="btn btn-xs btn-secondary" id="addOrderlineBtn">{{ trans('purchaseorder.addOrderlineBtn') }}</a>  
                </span>
            </div>        
            <div class="card-body container-fluid card-form">
                <div class="col-md-12 orderlinesContainer">
                    <div class="alert alert-info" role="alert">{!! trans('purchaseorder.addOrderlineText',['buttonName' => trans('purchaseorder.addOrderlineBtn')]) !!}</div>  
                </div>
                <table style="display: none;" class="table table-responsive" id="salesorderlinesTable">
                    <thead>
                        <tr>
                            <th class="narrow"></th>
                            <th class="narrow"></th>
                            <th style="min-width: 100px;">{{ trans('purchaseorder.orderQuantity') }}</th>
                            <th>{{ trans('product.sku') }}</th>
                            <th>{{ trans('product.name') }}</th>
                        </tr>
                    </thead>
                    <tbody id="salesorderlinesBody"></tbody>
                </table>   
            </div>
        </div>
        <div class="card">
            <div class="card-header">
            {{ trans('purchaseorder.createFormStep5') }}
            </div>        
            <div class="card-body container-fluid  card-form">
                <div class="form-group">
                    {!! Form::textarea('comment_text', null, ['class' => 'form-control texteditorPlain']) !!}
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

        <?php if (count($values) > 0){ echo '<input type="hidden" id="json" value=\'' . json_encode($values) . '\'/>'; }?>

        {!! Form::close() !!}

        @stop

        @section('footer')
        <script>
        
        $(function() {

            $('#customer').on('change', function(){
                $('#salesorderlinesBody').empty();    
            });

            $('#addOrderlineBtn').on('click' ,function(){
                if ($('#customer').val()){

                    var box = bootbox.dialog({
                        size: 'large',
                        message: '<select class="form-control selectProduct"></select>',
                        title: "{{ trans('purchaseorder.addOrderlinModalTitle') }}",
                        buttons: {
                            success: {
                                label: "{{ trans('general.modalCloseBtn') }}",
                                className: "btn-success",
                                callback: function() {}
                            }
                        }
                    });

                    box.modal('show');

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
                                    customer: $('#customer').val(), 
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
                                    '<img src="' + (row.thumbnail ? row.thumbnail : '{{ LAZY }}') + '" class="img-rounded img-thumb" />' +
                                    '</div>' + 
                                    '<div class="col-md-4">' + row.sku + '</div>' + 
                                    '<div class="col-md-5">' + row.name + '</div>' +
                                    '<div class="col-md-1 pull-right">' + row.qtyAvailable + '</div>' +
                                    '</div>'
                               );
                            }
                        }
                    }); 

                    $(".selectProduct").on('change', function() { 
                        $(this).attr('disabled','disabled');
                        if ($('.alert-info')[0]){
                            $('.alert-info')[0].remove(); 
                            $('#salesorderlinesTable').show();
                        }
                        $.postJSON('{{ url("ajax/product") }}/' + $(this).val() + '/' + $('#customer').val(), function(data){
                            data = data[0];
                            if (!$('.soRow[data-id="' + data.id + '" ]').length > 0){
                                $('#salesorderlinesBody').append(
                                    '<tr class="soRow" data-id="' + data.id + '">' +
                                    '<td>' +
                                    '<input type="hidden" name="product[]" value="' + data.id + '"/>' +
                                    '<img src="' + (data.thumbnail ? data.thumbnail : '{{LAZY}}') + '" class="img-rounded img-thumb" />' +
                                    '</td>' + 
                                    '<td><a onclick="deleteRow(\'' + data.id + '\',\'.soRow\')" class="btn btn-outline-warning btn-xs"><span class="fa fa-remove text-warning">{{ trans("purchaseorder.removeOrderlineForm") }}</span></a>' + 
                                    '<td><input class="form-control" type="number" value="1" name="quantityOrdered[]"/></td>' +
                                    '<td>' + data.sku + '</td>' + 
                                    '<td>' + data.name + '</td>' +
                                    '</tr>'
                               );   
                            }
                        });
                        $(this).removeAttr('disabled');
                    });
                }            
            });

            if ($('#json').val()){
                var json = jQuery.parseJSON($('#json').val());
                $.each(json, function(key, value) {
                    if ($('.alert-info')[0]){
                        $('.alert-info')[0].remove(); 
                        $('#salesorderlinesTable').show();
                    }
                    $.postJSON('{{ url("ajax/product") }}/' + value.product + '/' + $('#customer').val(), function(data){
                        data = data[0];
                        if (!$('.soRow[data-id="' + data.id + '" ]').length > 0){
                            $('#salesorderlinesBody').append(
                                '<tr class="soRow" data-id="' + data.id + '">' +
                                '<td>' +
                                '<input type="hidden" name="product[]" value="' + data.id + '"/>' +
                                '<img src="' + (data.thumbnail ? data.thumbnail : '{{ LAZY }}') + '" class="img-rounded img-thumb" />' +
                                '</td>' + 
                                '<td><a onclick="deleteRow(\'' + data.id + '\',\'.soRow\')" class="btn btn-warning-outline btn-xs"><span class="fa fa-remove">{{ trans("purchaseorder.removeOrderlineForm") }}</span></a>' + 
                                '<td><input class="form-control" type="number" value="' + value.quantity + '" name="quantityOrdered[]"/></td>' +
                                '<td>' + data.sku + '</td>' + 
                                '<td>' + data.name + '</td>' +
                                '</tr>'
                            );   
                        }
                    });
                });
            }
        });
        </script>
@stop 



