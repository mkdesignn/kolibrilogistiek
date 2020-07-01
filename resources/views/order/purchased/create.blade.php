@extends('layouts.app')

@section('content')
    @include('order.purchased.form', ["action"=>route('purchased.store'), "order"=>$order, "button"=>"create", 'method'=>'post'])
@endsection
