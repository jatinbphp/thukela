@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="card-title">{{$menu}}</h4>
                </div>
                <div class="card-body text-center">
                    @include("error")
                    <div class="row">
                        <div class="col-md-6 offset-3 border p-3" style="border-radius: 10px;">
                            <form action="{{route('user.sendContactUs')}}" method="post">
                                {{ csrf_field() }}
                                <div class="row mt-2 text-left">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Building Name</label>
                                            <input type="text" name="buildingname" class="form-control" placeholder="Building Name" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Flat Number</label>
                                            <input type="text" name="flatnumber" class="form-control" placeholder="Flat Number" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input type="text" name="phonenumber" class="form-control" placeholder="Phone Number" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Message</label>
                                            <input type="text" name="message" class="form-control" placeholder="Message" value="" required>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary btn-block" id="payNowBtn">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
