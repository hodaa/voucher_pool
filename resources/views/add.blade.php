@extends('layouts.app')

@section('title', 'Voucher Codes')

@section('stylesheet')
@endsection
@section('content')
    @if (app('request')->input('errors') )
            <div class="alert alert-danger">
                <ul>
                    @foreach (app('request')->input('errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
    @endif
    <div class="wrapper panel panel-default shadow-none p-3 mb-5 bg-light rounded">
        <h1>Add Voucher</h1>
        <form action="/save" method="post">
            <p>Date: <input type="text" name="expire_date" id="datepicker" class="form-control"></p>

            <select class="form-control" name="offer_id">

                </option>
                @foreach($offers as $key=>$item)
                    <option value="{{$key}}">{{$item}}</option>
                @endforeach
            </select>
            <br>
            <input type="submit" class="btn-primary" value="Submit">
        </form>
    </div>
    </div>

@endsection