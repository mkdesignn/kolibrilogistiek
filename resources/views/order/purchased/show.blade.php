@extends('layouts.app')

@section('content')
    @include('order.purchased.form', ["action"=>route('purchased.update', $order->id), 'method'=>'PUT', "order"=>$order, "button"=>"update"])
@endsection
