@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                    <tr>
                                        <th>Notification</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($notifications) > 0)
                                            @foreach($notifications as $key => $list)
                                                <tr>
                                                    <td>{{$list->description}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>No notifications</td>
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
