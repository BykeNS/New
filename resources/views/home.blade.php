@extends('layouts.app')
@section('title', 'Home')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3>Welcome {{ Auth::user()->name }}</h3>
                    
                   <p><img style="width: 80px; height: 100px;" src="{{ asset('img/rim.JPG') }}"></p>
                    <p>You are now logged in</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
