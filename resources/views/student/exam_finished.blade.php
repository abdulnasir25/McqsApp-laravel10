@extends('layout.app')

@section('content')

<div class="col-md-8 offset-md-2">
    <h1>EXAM FINISHED</h1>
    <p>Thank you..!</p>
    <br>
    <p>Click <a href="{{ route('student.exam.result') }}" class="btn btn-sm btn-success">Result</a> to see your exam result.</p>
</div>
@endsection