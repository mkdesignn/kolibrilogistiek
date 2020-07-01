@extends('base')
@section('content')
    <div class="container-fluid">
        @include('errors.form_errors')
        @include('partials.flash')            
        <div class="card">
            <div class="card-header">
                {{ trans('purchaseorder.ShowtitlePanel1') }}
                <div class="btn-group pull-right hidden-md-down">
                    <a href="{{ PREVIOUS_URL }}" class="btn btn-secondary btn-xs">{!! config('ds.icons.pageBack') !!} {{ trans('general.pageBack') }}</a>
                    <a href="{{ Request::url() }}" class="btn btn-secondary btn-xs">{!! config('ds.icons.refresh') !!} {{ trans('general.refreshPage') }}</a>
                    @if($po->is_return)
                        <a href="{{ action('SalesorderController@show', $po->salesorder_id) }}" class="btn btn-secondary btn-xs">{!! fa('fa fa-sign-out') !!} {{ trans('purchaseorder.goToOrder') }}</a>     
                    @endif                        
                    @can('allowCancel', $po)
                        <a data-confirm="{{ trans('purchaseorder.confirmCancel') }}" href="{{ action('PurchaseorderController@cancel', ['id' => $po->id]) }}" class="btn btn-secondary confirm btn-xs">{!! config('ds.icons.cancel') !!} {{ trans('purchaseorder.cancelOrder') }}</a>
                    @endcan
                    @can('allowClose', $po)
                        <a data-confirm="{{ trans('purchaseorder.confirmClose') }}" href="{{ action('PurchaseorderController@close', ['id' => $po->id]) }}" class="btn btn-secondary confirm btn-xs">{!! config('ds.icons.save') !!} {{ trans('purchaseorder.closeOrder') }}</a>
                    @endcan
                </div>
                <div class="btn-group pull-right hidden-md-up">
                    <a class="btn btn-secondary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">{{ trans('general.mobileDropdownAction') }}</a>
                    <div class="dropdown-menu">
                        <a href="{{ PREVIOUS_URL }}" class="dropdown-item">{!! config('ds.icons.pageBack') !!} {{ trans('general.pageBack') }}</a>
                        @can('allowCancel', $po)
                            <a href="{{ action('PurchaseorderController@cancel', ['id' => $po->id]) }}" class="dropdown-item">{!! config('ds.icons.cancel') !!} {{ trans('purchaseorder.cancelOrder') }}</a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="card-body container-fluid card-form">
                <div class="col-md-7">
                    @if($po->is_return)                        
                        <h3>{{ trans('purchaseorder.customer') }}</h3>
                        <address>
                            <?php $order = \DogStocker\Salesorder::find($po->salesorder_id); ?>
                            {{ $order->companyName ? $order->companyName . '<br>' : '' }}
                            {{ $order->firstName . ' ' . $order->lastName }}<br>
                            {{ trim($order->street . ' ' . $order->number . ' ' . $order->street2 . ' ' . $order->extension) }}<br>
                            {{ trim($order->postcode . ' ' . $order->city . ' ' . $order->region) }}<br>
                            {{ trim($order->country['name']) }}<br>
                            {{ trim($order->email) }}<br>
                            {{ trim($order->telephone) }}<br>
                        </address>
                    @else
                        <h3>{{ trans('purchaseorder.supplier') }}</h3>
                        <address>
                            @if($po->supplier)                            
                                {{ $po->supplier->name }}
                            @endif                            
                        </address>
                    @endif                        
                </div>
                <div class="col-md-5">
                    <h3>{{ trans('purchaseorder.orderDetails') }} 
                        @can('allowEdit', $po)
                            <a href="{{ url('/purchaseorders/' . $po->id . '/edit/details') }}" class="btn btn-secondary btn-xs pull-right">{!! config('ds.icons.edit') !!} <span class="hidden-md-down">{{ trans('general.edit') }}</span></a> 
                        @endcan
                    </h3>
                    {{ trans('purchaseorder.orderNumber') }}: <span class="pull-right">{{ $po->number }}</span><br>
                    {{ trans('purchaseorder.status') }}: <span class="pull-right" id="status">{!! $po->status['icon'] !!} {{ $po->status['name'] }}</span><br>
                    @if(admin())                        
                        {{ trans('purchaseorder.customer') }}: <span class="pull-right">{!! link_to_action('CustomerController@show', $title = $po->customer->name, $parameters = ['id' => $po->customer_id], $attributes = []) !!}</span><br>    
                    @endif                        
                    @if($po->snapshot)
                        {{ trans('purchaseorder.snapshot') }}: <span class="pull-right"><a target="_blank" href="{!! $po->snapshot !!}">{{ trans('general.click') }}</a></span><br>
                    @endif
                        {{ trans('general.createdBy') }}: <span class="pull-right">{{ $po->user->name }}</span><br>
                        {{ trans('purchaseorder.expected_at') }}: <span class="pull-right">{{ $po->expected_at }}</span><br>
                    @if ($po->received_at != '')
                        {{ trans('purchaseorder.received_at') }}: <span class="pull-right">{{ $po->received_at }}</span><br>
                    @endif
                    {{ trans('purchaseorder.createdAt') }}: <span class="pull-right">{{ $po->created_at }}</span><br>
                    {{ trans('purchaseorder.updatedAt') }}: <span class="pull-right">{{ $po->updated_at }}</span><br>
                    @can('isCancelled', $po)
                        {{ trans('purchaseorder.cancelledAt') }}: <span class="pull-right">{{ $po->cancelled_at }}</span><br>
                    @endcan
                    @if(!empty($po->trackandtrace))
                        {{ trans('purchaseorder.trackandtrace') }}: <span class="pull-right"><a href="{!! $po->trackandtrace !!}" target="_blank">{{ parse_url($po->trackandtrace)['host'] }}</a></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                {{ trans_choice('purchaseorder.ShowtitlePanel2', count($po->purchaseorderlines)) }}
                <div class="btn-group pull-right">
                    @can('allowEdit', $po)
                        <a href="{{ action('PurchaseorderController@addLine', [ 'id' => $po->id ]) }}" class="btn btn-secondary btn-xs">{!! config('ds.icons.edit') !!} <span class="hidden-md-down">{{ trans('purchaseorder.addOrderlineBtn') }}</span></a>
                    @endcan
                </div>
            </div>
            <div class="table-responsive table-responsive-no-margin">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="narrow-sm"></th>
                            @can('allowEdit', $po)
                                <th class="narrow-sm"></th>
                            @endcan
                            @can('allowReceive', $po)
                                <th class="narrow-sm"></th>
                            @endcan
                            <th class="narrow-sm">{{ trans('purchaseorder.qtyOrdered') }}</th>
                            <th class="narrow-sm">{{ trans('purchaseorder.qtyReceived') }}</th>
                            <th>{{ trans('product.sku') }}</th>
                            <th>{{ trans('product.name') }}</th>
                            <?php $validBatch = false; $validUhd = false; ?>
                            @foreach($po->purchaseorderlines as $line)
                                @if (isset($line->lineDetails))
                                    <?php $lineDetailArray = json_decode($line->lineDetails, true); ?>
                                    @foreach($lineDetailArray as $lineDetail)
                                        @if(isset($lineDetail[1]) && $validBatch == false)
                                            <?php $validBatch = true; ?>
                                            <th>{{ trans('purchaseorder.batch') }}</th>
                                        @endif
                                        @if(isset($lineDetail[2]) && $validUhd == false)
                                            <?php $validUhd = true; ?>
                                            <th>{{ trans('purchaseorder.tht') }}</th>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($po->purchaseorderlines as $line)
                            <tr @can('allowEdit', $po) data-quantity="{{ $line->quantity }}" data-orderline_id="{{ Crypt::encrypt($line->id) }}" @endcan>
                                <th scope="row"><?php if($line->product->thumbnail) { ?><img class="img img-thumb img-rounded lazy" data-src="{!! proxy_image($line->product->thumbnail) !!}" src="{!! LAZY !!}" /><?php } ?></th>
                                @can('allowEdit', $po)                   
                                    <td>
                                        <a class="btn btn-outline-secondary btn-xs editQuantity">{!! config('ds.icons.edit') !!}</a>                               
                                        <a class="btn btn-outline-secondary btn-xs deleteBtn">{!! config('ds.icons.cancel') !!}</a>
                                    </td>
                                @endcan                        
                                @can('allowReceive', $po)                                
                                    <td><a data-suggest="{{ $line->quantity - $line->quantity_received < 0 ? 0 : $line->quantity - $line->quantity_received }}" data-uhd="{{ $line->product->uhd ? '1' : '0' }}" data-batch="{{ $line->product->batch_number ? '1' : '0' }}" data-sku="{{ $line->product->sku }}" data-name="{{ $line->product->name }}" data-quantity="{{ $line->quantity }}" data-orderline_id="{{ $line->id }}" data-product_id="{{ $line->product_id }}" class="btn btn-outline-secondary btn-xs receive">{!! fa('fa fa-download text-primary') !!}&nbsp;&nbsp;{{ trans('purchaseorder.process') }}</a></td>
                                @endcan                                
                                <td>{{ $line->quantity }}</td>
                                <td id="{{ $line->id }}">{{ $line->quantity_received }}</td>
                                <td><a href="{{ action('ProductController@show', [$line->product_id] ) }}">{{ $line->product->sku }}</a></td>
                                <td>{{ $line->product->name }}</td>
                                <td>                                    
                                    @if(isset($line->lineDetails))                                        
                                        <?php $lineDetailArray = json_decode($line->lineDetails, true); ?>
                                        @foreach($lineDetailArray as $lineDetail)
                                            @if(isset($lineDetail[1]))
                                                {{ $lineDetail[1] }} ({{ $lineDetail[0] }}) <br>
                                            @endif
                                        @endforeach
                                    @endif  
                                </td>
                                <td>
                                    @if(isset($line->lineDetails))
                                        <?php $lineDetail = json_decode($line->lineDetails, true); ?>
                                        @foreach($lineDetailArray as $lineDetail)
                                            @if(isset($lineDetail[2]))
                                                {{ $lineDetail[2] }} ({{ $lineDetail[0] }}) <br>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                        @endforeach           
                    </tbody>
                </table>
            </div>
        </div>    
        <div class="row">
            <div class="col-md-6">
                @include('partials.comments')  
            </div>
            <div class="col-md-6">
                @include('partials.events')
            </div>
        </div>
    </div>
@stop
            
@section('footer')            
@can('allowReceive', $po)
    <script>    
        $(function(){
           
            $(document).on('shown.bs.modal', function() {
                var data = $('.receive').data();
                $('.uhd').datepicker({
                    language: config.language,
                    format: 'dd-mm-yyyy',
                    clearBtn: true,
                    todayHighlight: true,
                    weekStart: 1,
                    autoclose: true,
                    orientation: 'bottom right'
                });
            });
            
            $('.receive').on('click', function(){                
                var data = $(this).data();
    
                var form = `<label for="quantity">{{ trans('purchaseorder.receiveline') }}</label>
<input type="number" class="form-control" id="quantity" value="${data.suggest}" name="quantity"/>`;
                
                if (data.batch == '1') {
form += `<label for="batch">{{ trans('purchaseorder.batch') }}</label>
<input type="text" class="form-control batch" id="batch" name="batch"/>
`;
                }
                
                if (data.uhd == '1') {
form += `<label for="uhd">{{ trans('purchaseorder.tht') }}</label>
<input type="text" class="form-control uhd" id="uhd" name="uhd"/>
`;
                }
                
form += `<label for="location">{{ trans('purchaseorder.location') }}</label>
<select class="form-control select2-selectLocation" id="location"></select>`;
                
                var prompt = bootbox.dialog({ 
                    title: data.name + '<br><small>' + data.sku + '</small>',    
                    size: 'large',
                    message: form,
                    buttons: {
                        cancel: {
                            label: '{{ trans('purchaseorder.buttons.cancel') }}',
                            className: 'btn-danger',
                            callback: function(result){
                                
                            }
                        },
                        save : {
                            label: '{{ trans('purchaseorder.buttons.save') }}',
                            className: 'btn-success',
                            callback: function(result) {
                                if (result){
                                    $.ajax({
                                        dataType: 'json',
                                        url: "{{ action('PurchaseorderController@receive', ['id' => $po->id]) }}",
                                        type: 'post',
                                        data: {
                                            _method: 'PATCH',
                                            quantity: $('#quantity').val(),
                                            uhd: $('#uhd').val(),
                                            batch_number: $('#batch').val(),
                                            location: $('#location').val(),
                                            id: '{{ $po->id }}',
                                            orderline_id: data.orderline_id
                                        }
                                    }).done(function(response) {
                                        $('#status').html(response.status);
                                        $('#' + data.orderline_id).text(response.quantity);
                                        console.log(response);
                                        prompt.modal('hide');
                                        location.reload();
                                    }).error(function(errors){
                                        console.log(errors);
                                        handleErrors(errors);
                                        return false;
                                    });    
                                }
                                return false;
                            }
                        }
                    }
                });
            
                $('.select2-selectLocation').select2({
                    placeholder: "Zoek een locatie...",
                    minimumInputLength: 2,
                    ajax: {
                        url: "../ajax/product/" + data.product_id + "/locations",
                        method: 'post',
                        dataType: 'json',
                        delay: 100,
                        cache: false,
                        data: function (params) {
                            return {
                                search: params.term, 
                            }
                        },
                        processResults: function (data, page) {
                            return {
                                results: data
                            }
                        }
                    },
                    templateResult: function formatState (row) {
                        if (row.text){
                            return $('<span>' + row.text + '</span><span class="pull-right">' + row.icon_string + '&nbsp;&nbsp;</span>');
                        }
                    } 
                });
                
            });
        
        });
        </script>
@endcan            
            
@can('allowEdit', $po)
            
        <script>    
        $(function(){
                    
            $('.receive').on('')
            
            $('.editQuantity').on('click', function(){ 
                var tr = $(this).closest('tr');
                var ordered = tr.children('.ordered');
                var reserved = tr.children('.reserved');
                    bootbox.prompt({ 
                        size: 'small',
                        inputType: 'number',
                        title: "{{ trans('purchaseorder.EditPurchaseorderlineQuantity') }}",
                        value: tr.data('quantity'),
                        callback: function(result){
                            if (result){
                            $.ajax({
                              dataType: 'json',
                              url: "{{ action('PurchaseorderController@editLine',['id' => $po->id]) }}",
                              type: "post",
                              data: {
                                  _method: 'PATCH',
                                  uuid: '{{ $po->uuid }}',
                                  id: '{{ $po->id }}',
                                  orderline_id: tr.data('orderline_id'),
                                  quantity: result
                              }
                            }).done(function(data) {
                                location.reload();
                            }).error(function(errors){
                                handleErrors(errors);
                            });
                          return false;    
                        }}
                    })
                }); 
            $('.deleteBtn').on('click', function(){ 
                var tr = $(this).closest('tr');
                var ordered = tr.children('.ordered');
                var reserved = tr.children('.reserved');
                    bootbox.confirm({ 
                        size: 'small',
                        title: "{{ trans('purchaseorder.DeletePurchaseorderline') }}",
                        message: "{{ trans('general.confirm') }}",
                        callback: function(result){
                            if (result){
                            $.ajax({
                              dataType: 'json',
                              url: "{{ action('PurchaseorderController@deleteLine', ['id' => $po->id]) }}",
                              type: "post",
                              data: {
                                  _method: 'DELETE',
                                  uuid: '{{ $po->uuid }}',
                                  id: '{{ $po->id }}',
                                  orderline_id: tr.data('orderline_id'),
                                  quantity: result
                              }
                            }).done(function(data) {
                                location.reload();
                            }).error(function(errors){
                                handleErrors(errors);
                            });
                          return false;    
                        }}
                    })
                });          
        });          
        </script>  
            
@endcan
            
@stop 
