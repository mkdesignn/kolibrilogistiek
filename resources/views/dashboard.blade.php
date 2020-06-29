@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Shipped orders</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="exampleInputEmail1">Select the date</label>
                            <input type="text" name="dates" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="click to select the date">
{{--                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>--}}
                        </div>
                        <canvas id="myChart" width="300" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
