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

    <script>

        const START_DATE = "08/01/2019";
        const END_DATE = "09/01/2019";

        $('input[name="dates"]').daterangepicker(
            {
                startDate: START_DATE,
                endDate: END_DATE
            },
            function(start, end) {
                console.log(start.format('YYYY-MM-DD'));
                console.log(end.format('YYYY-MM-DD'));
                // console.log(start);
                // console.log(end);
            }
        );

        new Chart(document.getElementById("myChart"), {
            type: 'line',
            data: {
                labels: [new Date("2015-3-15 13:3").toLocaleString(), new Date("2015-3-25 13:2").toLocaleString(), new Date("2015-4-25 14:12").toLocaleString()],
                datasets: [
                    {
                        data: [86,114, 34],
                        label: "Africa",
                        borderColor: "#3e95cd",
                        fill: false
                    }
                ]
            },
            options: {
                title: {
                    display: true,
                    text: 'World population per region (in millions)'
                },
                scales: {
                    xAxes: [{
                        type: 'time'
                    }]
                }
            }
        });
    </script>
@endsection
