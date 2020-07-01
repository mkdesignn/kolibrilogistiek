<?php $action = 'PurchaseorderController'; ?>
@extends('base')
@section('content')
    @include('partials.flash')
    <div class="row">
        <div id="toolbar">
            <div class="btn-group">
                @include('partials.purchaseorderStatusMenu')
                @include('partials.customerMenu')
            </div>
            <div class="btn-group hidden-md-down">

                <a href="{{ action('PurchaseorderController@create') }}" class="btn btn-secondary btn-xs">{!! config('ds.icons.create') !!} {{ trans('purchaseorder.createOrder') }}</a>
                <a href="{{ Request::fullUrl() }}" class="btn btn-secondary btn-xs">{!! config('ds.icons.refresh') !!} {{ trans('general.refreshPage') }}</a>
                @if(count($_GET))
                    <a href="{{ Request::Url() }}" class="btn btn-secondary btn-xs">{!! config('ds.icons.resetPage') !!} {{ trans('general.resetPage') }}   </a>
                @endif
            </div>
        </div>
    </div>
    <div class="table-responsive bsTableResponsive">
        <table id="purchaseorderTable"
               data-bootstrap-table="true"
               data-buttons-align="right"
               data-toolbar="#toolbar"
               data-sort-name="created_at"
               data-sort-order="desc"
               data-search="true"
               data-cookie="true"
               data-show-export="true"
               data-export-name="{{ trans('purchaseorder.export', ['date' => Date::datetime()]) }}"
               data-export-ignore="[0]"
               data-target-url="{{ action('PurchaseorderController@show', '%%') }}"
               data-classes="{{ config('ds.bootstrapTable.classes') }}"
               data-url="{{ action('PurchaseorderController@xhrIndex') . '?' . http_build_query($_GET) }}"
               data-show-refresh="{{ config('ds.bootstrapTable.showRefresh') }}"
               data-pagination="{{ config('ds.bootstrapTable.pagination') }}"
               data-page-list="{{ config('ds.bootstrapTable.pageList') }}"
               data-key-events="{{ config('ds.bootstrapTable.keyEvents') }}"
               data-cookie-id-table="purchaseorders{{ Auth::id() }}"
               data-flat="true"
               data-locale="{{ App::getLocale() }}">
            <thead>
                <tr>
                    <th data-width="35" data-field="id" data-switchable="false" data-formatter="BT_linkFormat"></th>
                    <th data-field="status.icon_string">{{ trans('purchaseorder.status') }}</th>
                    @if(admin())                        
                        <th data-field="customer.name">{{ trans('general.customer') }}</th>
                    @endif                        
                    <th data-sortable="true" data-field="is_return" data-visible="true" data-formatter="BT_booleanFormat">{{ trans('purchaseorder.is_return') }}</th>
                    <th data-sortable="true" data-field="created_at" data-visible="true">{{ trans('general.created_at') }}</th>
                    <th data-sortable="true" data-field="received_at" data-visible="false">{{ trans('purchaseorder.received_at') }}</th>
                    <th data-sortable="true" data-field="expected_at" data-visible="true">{{ trans('purchaseorder.expected_at') }}</th>
                    <th data-sortable="true" data-field="number" data-visible="true">{{ trans('purchaseorder.orderNumber') }}</th>
                    <th data-sortable="true" data-field="supplier.name" data-visible="true">{{ trans('purchaseorder.supplier') }}</th>
                </tr>
            </thead>
        </table>
    </div>
@stop
@section('footer')
    <script>        
        $(document).ready(function() {
            // Get all cookies
            var cookies = document.cookie;
            // If cookies includes the specific string, set cookie to false and clear search
            if (cookies.includes('clearSearch=true'))
            {
                document.cookie = "clearSearch=false";
                $('#purchaseorderTable').bootstrapTable("resetSearch","");
            }            
        });
    </script>
@stop