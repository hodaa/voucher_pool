@extends('layouts.app')
@section('title', 'Home')
@section('content')
    @if (app('request')->input('created') )
        <div class="success alert-success">
            <span> Voucher Codes Created successfully</span>
        </div>

    @endif
    <div class="wrapper panel panel-default">
        <div class="row">
            <h1><a href="{{url()}}">Voucher Pool</a></h1>
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
                    <a type="button" class="btn btn-info col-md-2 pull-left" href="{{route('create')}}">Add Voucher
                        Code</a>
                    <input type="hidden" value="{{url()}}" id="url">
                    <input type="text" class="input-group pull-right col-md-3" placeholder="search" id="search">
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
                        @if(count($data['codes']))
                            @foreach($data['codes'] as $code)
                                <tr>
                                    <td>{{$code->code}}</td>
                                    <td>@if($code->used_on)
                                            <span class="glyphicon glyphicon-ok"></span>
                                        @else<span class="glyphicon glyphicon-remove"></span>
                                        @endif
                                    </td>
                                    <td>{{$code->recipient->email}}</td>
                                    <td>@if($code->used_on){{ date('d.m.Y', strtotime($code->used_on)) }} @endif</td>
                                </tr>

                            @endforeach
                        @else
                            <tr>
                                <td>No Codes Found</td>
                            </tr>
                        @endif


                        </tbody>

                    </table>
                    <div class="clearfix"></div>
                    <div class="pull-right"> {{ $data['codes']->links() }}</div>

                </div>

            </div>
        </div>
    </div>
@endsection
