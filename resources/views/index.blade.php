@extends('layouts.app')
@section('title', 'Home')
@section('content')
    <div class="wrapper panel panel-default">
        <div class="row">
            <h1>Voucher Pool</h1>
            <div class="col-sm-4">
                <h2>{{number_format($data['total_vouchers'],2) }}</h2>
                All Voucher Codes
            </div>
            <div class="col-sm-4">
                <h2>{{ number_format($data['used_vouchers'],2) }}</h2>
                Not Used Voucher
            </div>
            <div class="col-sm-4">
                <h2>{{ number_format($data['unused_vouchers'],2) }}</h2>
                Used Voucher
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class=" wrapper panel panel-default">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <a type="button" class="btn btn-info col-md-2 pull-left" href="{{route('profile')}}">Add Voucher Code</a>
                    <input type="text" class="input-group pull-right col-md-3" placeholder="search">
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
                <br>
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordred table-striped">

                        <thead>

                        <th>Code</th>
                        <th>Status</th>
                        <th>Employeer</th>
                        <th>Date</th>

                        </thead>
                        <tbody>

                        @foreach($data['codes'] as $code)
                            <tr>
                                <td>{{$code->code}}</td>
                                <td>@if($code->status)
                                        <span class="glyphicon glyphicon-ok"></span>
                                    @else<span class="glyphicon glyphicon-remove"></span>
                                    @endif
                                </td>
                                <td>{{$code->recipient->email}}</td>
                                <td>{{$code->used_date}}</td>
                            </tr>

                        @endforeach

                        </tbody>

                    </table>
                    <div class="clearfix"></div>
                    <div class="pull-right"> {{ $data['codes']->links() }}</div>

                </div>

            </div>
        </div>
    </div>
@endsection
