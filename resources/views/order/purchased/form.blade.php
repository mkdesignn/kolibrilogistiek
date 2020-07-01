@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            {{Form::open(['url'=>$action, 'method'=>$method])}}
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            General purchase order detail
                            <button class="btn btn-info" type="submit" style="float:right">{{$button}}</button>
                        </div>

                        <div class="card-body">

                            {{ !empty(Session::get('status'))? message(Session::get('status')):"" }}
                            {{ errors($errors) }}

                            <div class="row">

                                @if($loggedUser->isAdmin())
                                    <div class="col-md-6 col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Customer</label>
                                            <select name="customer" class="form-control customers"></select>
                                        </div>
                                    </div>
                                @endif

                                    <div class="col-md-6 col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Supplier</label>
                                            <select name="supplier_id" style="width:100%;" class="form-control supplier">
                                                @if($order->supplier_id !== null)
                                                    <option value="{{$order->supplier_id}}">{{$order->supplier->name}}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="reference">Purchase order reference</label>
                                        {{Form::text('number', $order->number, ['class'=>'form-control'])}}
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="Expected">Expected at</label>
                                        {{Form::text('expected_at', $order->expected_at, ['class'=>'form-control expected_date'])}}
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="track">Track & trace</label>
                                        {{Form::text('trackandtrace', $order->trackandtrace, ['class'=>'form-control'])}}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-10 purchase-order" style="margin-top:20px;">
                    <input type="hidden" id="order_id" v-model="order_id">

                    <div class="card">
                        <div class="card-header">
                            Purchase order lines
                            <button class="btn btn-info" v-on:click="AddPurchaseOrder" style="float:right">Add purchase order line</button>
                        </div>
                        <div class="card-body">
                            <div class="row-purchase-order">

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="width:10%;" scope="col">Quantity</th>
                                            <th style="width:10%;" scope="col">SKU</th>
                                            <th style="width:20%;" scope="col">Name</th>
                                            <th scope="col">Batch</th>
                                            <th scope="col">Expiry date</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="(purchase_order, index) in purchase_order_rows">

                                            <td>
                                                <div class="form-group">
                                                    <input :name="'quantity['+index+']'" type="text" :value="purchase_order.quantity" class="form-control" >
                                                </div>
                                            </td>

                                            <td>
                                                <div class="form-group">
                                                    <input :name="'sku['+index+']'" type="text" disabled :value="purchase_order.sku" class="form-control" >
                                                </div>
                                            </td>

                                            <td>
                                                <div class="form-group">
                                                    <select :name="'product['+index+']'" :id="'product_'+index" style="width:100%;" class="products">
                                                        <option v-if="purchase_order.product_id" :value="purchase_order.product_id">@{{purchase_order.product_name}}</option>
                                                    </select>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="form-group">
                                                    <input :name="'batch['+index+']'" type="text" v-model="purchase_order.batch" class="form-control" >
                                                </div>
                                            </td>

                                            <td>
                                                <div class="form-group">
                                                    <input :name="'expire_date['+index+']'" type="text" :id="'expire_date_'+index" :value="purchase_order.expire_date" class="form-control expire_date" >
                                                </div>
                                            </td>

                                            <td>
                                                <a v-on:click="removePurchaseOrder(index)" class="btn btn-outline-warning btn-xs">
                                                    Remove
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>
            {{Form::close()}}
        </div>
    </div>
@endsection

@section('footer')
    <script>
        let order_id = "{{$order->id}}";
    </script>
    <script src="{{ asset('js/purchase-order.js') }}"></script>
@endsection
