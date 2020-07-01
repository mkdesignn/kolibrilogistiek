<?php $action = 'SalesorderController'; ?>
@extends('base')
@section('content')
@include('partials.flash')
<div class="row">
    <div class="col-xs-6 pull-left">
        <div class="btn-group">
    @include('partials.salesorderStatusMenu')
    @include('partials.customerMenu')
    @include('partials.shopMenu')
        </div>
        <div class="btn-group hidden-md-down">
            <a href="{{ url('/salesorder/create') }}" class="btn btn-secondary btn-xs">{!! config('ds.icons.create') !!} {{ trans('salesorder.createOrder') }}</a>
            <a href="{{ Request::fullUrl() }}" class="btn btn-secondary btn-xs">{!! config('ds.icons.refresh') !!} {{ trans('general.refreshPage') }}</a>
        </div>
    </div>
    <div class="col-xs-6 pull-right">
        <div class="input-group pull-right ">
          <input type="text" value="{{ ( isset($_GET['search']) ? urldecode($_GET['search']) : '' ) }}" class="form-control input-xs pull-right input-search" data-search-url="{!! action('SalesorderController@index') !!}" placeholder="{{ trans('general.searchPlaceholder') }}">
          <span class="input-group-btn">
            <a class="btn btn-secondary btn-xs btn-search" type="button">{!! config('ds.icons.search') !!}</a>
          </span>
        </div>
      </div>
    </div>
    <div class="table-responsive table-responsive-no-margin">
        <table data-bootstrap-table="true"
               data-target-url="{{ url('/salesorder/%%') }}"
               data-classes="table-bordered table-sm table-striped"
               data-method="get" 
               data-url="{{ url('/ajax/salesorders') }}"
               data-height=""
               data-pagination="true"
               data-page-list="[5, 10, 20, 50, 100]"
               data-sort-name="created_at"
               data-sort-order="desc"
               data-cookie="true"
               data-cookie-id-table="salesorders"
               data-search="true">
            <thead>
            <tr>
                <th data-width="10" data-switchable="false" data-field="id" data-formatter="BT_linkFormat"></th>
                <th data-sortable="true" data-field="status">{{ trans('salesorder.status') }}</th>
                <th data-sortable="true" data-field="customer">{{ trans('salesorder.customer') }}</th>
                <th data-sortable="true" data-field="shop">{{ trans('salesorder.shop') }}</th>
                <th data-sortable="true" data-field="orderNumber">{{ trans('salesorder.orderNumber') }}</th>
                <th data-sortable="true" data-field="orderNumberAdditional">{{ trans('salesorder.orderNumberAdditional') }}</th>
                <th data-sortable="true" data-field="completeName">{{ trans('salesorder.completeName') }}</th>
                <th data-sortable="true" data-field="lastName">{{ trans('salesorder.lastName') }}</th>
                <th data-sortable="true" data-field="companyName">{{ trans('salesorder.companyName') }}</th>
                <th data-sortable="true" data-field="email">{{ trans('salesorder.email') }}</th>
                <th data-sortable="true" data-field="telephone">{{ trans('salesorder.telephone') }}</th>
                <th data-sortable="true" data-field="street">{{ trans('salesorder.street') }}</th>
                <th data-sortable="true" data-field="street2">{{ trans('salesorder.street2') }}</th>
                <th data-sortable="true" data-field="number">{{ trans('salesorder.number') }}</th>
                <th data-sortable="true" data-field="postcode">{{ trans('salesorder.postcode') }}</th>
                <th data-sortable="true" data-field="city">{{ trans('salesorder.city') }}</th>
                <th data-sortable="true" data-field="region">{{ trans('salesorder.country') }}</th>
                <th data-sortable="true" data-field="username">{{ trans('general.createdByName') }}</th>
                <th data-sortable="true" data-field="created_at">{{ trans('salesorder.created_at') }}</th>
                <th data-sortable="true" data-field="shipped_at">{{ trans('salesorder.shippedAt') }}</th>
                <th data-sortable="true" data-field="ship_at">{{ trans('salesorder.ship_at') }}</th>
                <th data-sortable="true" data-field="cancelled_at">{{ trans('salesorder.cancelledAt') }}</th>
            </tr>
            </thead>
        </table>
    </div>

@stop