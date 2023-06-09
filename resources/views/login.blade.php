@extends('layout.app')

@section('content')

<div class="col-md-8 offset-md-2">
    <legend>Login</legend>
    <br>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p style="color: red;">{{ $error }}</p>
        @endforeach
    @endif
    
    @if (Session::has('error'))
        <p style="color:red;">{{ Session::get('error') }}</p>
    @endif
    @if (Session::has('success'))
        <p style="color:green;">{{ Session::get('success') }}</p>
    @endif
    
    <form action="{{ route('login') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
        </div>
        
        <button type="submit" class="btn btn-primary" style="background:black;">Login</button>
    </form>
</div>
@endsection