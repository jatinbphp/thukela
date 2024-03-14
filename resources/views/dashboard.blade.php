@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="card-title">Welcome {{$name}}</h4>
                    <h5 class="card-category">Ledger: {{$ledger}}</h5>
                    <h5 class="card-category mb-0">Beneficiary Reference: {{$beneficiary}}</h5>
                </div>
                <div class="card-body text-center">
                    <div class="row">
                        <div style="margin: 0 auto">
                            <div id="gauge_div" style="width:fit-content; height: 250px;"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="amount" class="form-control" placeholder="R150.00" value="">
                                    </div>
                                    <button class="btn btn-primary btn-block" id="payNowBtn">Pay Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('jquery')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type='text/javascript'>
        google.charts.load('current', {'packages':['gauge']});
        google.charts.setOnLoadCallback(drawGauge);

        var gaugeOptions = {min: 0, max: 500, redFrom: 0, redTo: 100, yellowFrom: 101, yellowTo: 300, greenFrom: 301, greenTo: 500,  majorTicks: ['0','100', '200', '300', '400', '500'], minorTicks: 0};
        var gauge;

        function drawGauge() {
            gaugeData = new google.visualization.DataTable();
            gaugeData.addColumn('number', 'Balance');
            gaugeData.addRows(1);
            gaugeData.setCell(0, 0, {{$balance}});

            gauge = new google.visualization.Gauge(document.getElementById('gauge_div'));
            gauge.draw(gaugeData, gaugeOptions);
        }
    </script>
@endsection
