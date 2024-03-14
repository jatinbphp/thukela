@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
{{--                    <h4 class="card-title">Welcome {{$name}}</h4>--}}
{{--                    <h5 class="card-category">Ledger: {{$ledger}}</h5>--}}
{{--                    <h5 class="card-category mb-0">Beneficiary Reference: {{$beneficiary}}</h5>--}}
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="container" style="width: 100%;">
                                <div class="row border-bottom">
                                    <div class="col-md-12 text-center">
                                        <h4 class="my-0">Select Date Range</h4>
                                    </div>
                                    <div class="col-md-8 offset-2">
                                        <form action="{{route('user.provisionalbill')}}" method="get">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Start Date</label>
                                                        <input type="date" name="sDate" class="form-control" placeholder="Start Date" value="" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>End Date</label>
                                                        <input type="date" name="eDate" class="form-control" placeholder="End Date" value="" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 pt-3">
                                                    <button class="btn btn-primary btn-block">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <canvas id="canvas" style="background: #100740"></canvas>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <h4 class="card-title text-center">Provisional Bill</h4>
                            <div class="row">
                                @php
                                    $totalTeriff = $provisionalBill['bill']['li'];
                                    $totalConsumption = count($totalTeriff) > 0 ? number_format(array_sum(array_column($totalTeriff,'units')),2) : 0.0;
                                    $unit = count($totalTeriff) > 0 ? $totalTeriff[0]['unitsunit'] : '';
                                    $startR = preg_replace('/[a-zA-Z]/', '', $provisionalBill['readings']['mr']['start']['E1']) ;
                                    $endR =  preg_replace('/[a-zA-Z]/', '', $provisionalBill['readings']['mr']['end']['E1']);
                                    $totalNewConsumption = $endR - $startR;
                                @endphp

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3 font-weight-bold">
                                            Customer :
                                        </div>
                                        <div class="col-md-3">
                                            @php
                                                //$cName = explode(';',$provisionalBill['key2']);
                                                $cName = $provisionalBill['key2'];
                                            @endphp
                                            {{$provisionalBill['key2']}}
                                        </div>
                                        <div class="col-md-3 font-weight-bold">
                                            Document Date :
                                        </div>
                                        <div class="col-md-3">
                                            {{$provisionalBill['documentdate']}}
                                        </div>

                                        <div class="col-md-3 font-weight-bold mt-2">
                                            Meter Account :
                                        </div>
                                        <div class="col-md-9 mt-2">
                                            {{$provisionalBill['key2']}}
                                        </div>

                                        <div class="col-md-3 font-weight-bold mt-2">
                                            Period :
                                        </div>
                                        <div class="col-md-9 mt-2">
                                            From {{$provisionalBill['startdate']}} to {{$provisionalBill['enddate']}}
                                        </div>

                                        <div class="col-md-3 font-weight-bold mt-2">
                                            Tariff :
                                        </div>
                                        <div class="col-md-9 mt-2">
                                            {{$provisionalBill['tariff']}}
                                        </div>

                                        <div class="col-md-3 font-weight-bold mt-2">
                                            Meter Totals :
                                        </div>
                                        <div class="col-md-3 mt-2">
                                            {{$provisionalBill['readings']['mr']['snumber']}}
                                            ({{$provisionalBill['readings']['mr']['mtype']}})
                                        </div>
                                        <div class="col-md-3 font-weight-bold mt-2">
                                            Consumption :
                                        </div>
                                        <div class="col-md-3 mt-2">
{{--                                            {{$totalConsumption}}--}}
                                            {{$totalNewConsumption.$unit}}
                                        </div>

                                        <div class="col-md-3 font-weight-bold mt-2">
                                            Start reading :
                                        </div>
                                        <div class="col-md-3 mt-2">
                                            {{$provisionalBill['readings']['mr']['start']['E1']}}
                                        </div>
                                        <div class="col-md-3 font-weight-bold mt-2">
                                            End reading :
                                        </div>
                                        <div class="col-md-3 mt-2">
                                            {{$provisionalBill['readings']['mr']['end']['E1']}}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-4">
                                    <span class="font-weight-bold">{{$provisionalBill['key1']}} {{$provisionalBill['util']}}: Consumption: {{$totalNewConsumption.$unit}}</span>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class=" text-primary">
                                            <tr>
                                                <th>Tariff</th>
                                                <th>Description</th>
                                                <th>Units</th>
                                                <th>Rate[R]</th>
                                                <th>Amount</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($provisionalBill['bill']['li']) > 0)
                                                @foreach($provisionalBill['bill']['li'] as $key => $list)
                                                    <tr>
                                                        <td>{{$list['tname']}}</td>
                                                        <td>{{!empty($list['desc2']) ? $list['desc2'] : ''}}</td>
                                                        <td>{{number_format($list['units'],2).$list['unitsunit']}}</td>
                                                        <td>{{number_format($list['rate'],4)}}</td>
                                                        <td>R{{number_format($list['amount'],2)}}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="font-weight-bold">Sub Total</td>
                                                    <td>R{{number_format($provisionalBill['total_taxed'],2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="font-weight-bold">
                                                        <div>Total before {{$provisionalBill['taxtype']}}</div>
                                                        <div class="mt-2">{{$provisionalBill['taxtype']}} ({{number_format($provisionalBill['taxperc'],1).'%'}})</div>
                                                        <div class="mt-2">Total</div>
                                                    </td>
                                                    <td>
                                                        <div>R{{number_format($provisionalBill['total_taxed'],2)}}</div>
                                                        <div class="mt-2">R{{number_format($provisionalBill['tax'],2)}}</div>
                                                        <div class="mt-2">R{{number_format($provisionalBill['total'],2)}}</div>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="5">Data Not Found</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
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
    <script type="text/javascript" src="https://www.chartjs.org/dist/master/chart.js"></script>
    <script type='text/javascript'>
        var barChartData = {
            labels: {!! $chartDates !!},
            datasets: {!! $readingData !!}
        };

        var chartOptions = {
            responsive: true,
            legend: {
                position: "right",
                display: false
            },
            title: {
                display: true,
                text: "Account Id: {{$provisionalBill['key1']}}",
                fontColor: "#ffffff",
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontColor: "#ffffff",
                    }
                }],
                xAxes: [
                    {
                        ticks: {
                            callback: function(label, index, labels) {
                                if (/\s/.test(label)) {
                                    return label.split(" ");
                                }else{
                                    return label;
                                }
                            },
                            fontColor: "#ffffff",
                        }
                    }
                ]
            }
        }

        window.onload = function() {
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: "bar",
                data: barChartData,
                options: chartOptions
            });
        };


    </script>
@endsection
