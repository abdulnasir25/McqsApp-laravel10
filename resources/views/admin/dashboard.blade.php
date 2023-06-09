@extends('layout.app')

@section('content')

@include('common.sidebar')

<div class="col-md-9">
    <div class="card">
        <div class="card-header">
            Admin Dashboard
        </div>
        <div class="card-body">
            <h1>Welcom <b><i>{{ auth()->user()->name }}</i></b> to your dashboard..!</h1>
        </div>
    </div>
</div>

@endsection