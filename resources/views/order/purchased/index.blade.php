@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">list of purchased orders</div>
                    <div class="card-body">
                        {{ !empty(Session::get('msg')) ? message(Session::get('msg')):"" }}
                        {{ errors($errors) }}

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">uuid</th>
                                <th scope="col">customer name</th>
                                <th scope="col">number</th>
                                <th scope="col">shipped</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($purchased as $purchase)
                                    <tr>
                                        <th scope="row">{{$purchase->id}}</th>
                                        <th scope="row">{{$purchase->uuid}}</th>
                                        <td>{{$purchase->customer->name}}</td>
                                        <td>{{$purchase->number}}</td>
                                        <td>{{$purchase->shipped_at}}</td>
                                        <td>
                                            <p>
                                                <a href="{{route('purchased.show', $purchase->id)}}" class="btn btn-primary">Edit</a>
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $purchased->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
