@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="card-title">{{$transactionsData['key2']}}</h4>
                    <h5 class="card-category">Ledger: {{$transactionsData['key1']}}</h5>
                    <h5 class="card-category">Beneficiary Reference: {{$transactionsData['key1']}}</h5>
                </div>
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-md-6 offset-3 border p-3" style="border-radius: 10px;">
                            <div class="row">
                                <div class="col-md-6 text-left">Opened Date</div>
                                <div class="col-md-6 text-right">{{date('Y-m-d', strtotime($transactionsData['odate']))}}</div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 text-left">Closing Balance</div>
                                <div class="col-md-6 text-right">{{ 'R '.$transactionsData['cbal']}}</div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 text-left">Opening Balance</div>
                                <div class="col-md-6 text-right">{{ 'R '.$transactionsData['obal']}}</div>
                            </div>

                            <form action="{{route('user.transactions')}}" method="get">
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="date" name="startDate" class="form-control" value="{{$startDate}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="date" name="endDate" class="form-control" value="{{$endDate}}">
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block" id="payNowBtn">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                        <tr>
                                            <th>Transaction Number</th>
                                            <th>Date & Time</th>
                                            <th>Amount</th>
                                            <th>Transaction Type</th>
                                            <th>Description</th>
                                            <th>Running Total</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            @if(count($transactions) > 0)
                                                @php
                                                        $closingBalance = $transactionsData['cbal'];
                                                        $i = 0;
                                                @endphp
                                                @foreach($transactions as $key => $list)
                                                    @php
                                                        $amt = $list['amt'] / 100000;
                                                        if($i == 0){
                                                                $balance = $closingBalance;
                                                        }else{
                                                                $newAmt = $transactions[$key - 1]['amt'] / 100000;
                                                                $balance = $transactions[$key - 1]['tpe'] == 'I' ? $closingBalance + str_replace('-','',$newAmt) : $closingBalance - str_replace('-','',$newAmt);
                                                                $closingBalance = $balance;
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td>{{$list['num']}}</td>
                                                        <td>{{$list['tdate']}}</td>
                                                        <td>{{$amt}}</td>
                                                        <td>{{$list['tpe'] == 'I' ? 'Invoice' : 'Receipt'}}</td>
                                                        <td>{{$list['descr']}}</td>
                                                        <td>{{ $i == 0 ? $transactionsData['cbal'] : $balance}}</td>
                                                    </tr>
                                                    @php $i++; @endphp
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="6">Data Not Found</td>
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
@endsection
