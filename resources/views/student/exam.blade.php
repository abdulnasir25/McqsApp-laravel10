@extends('layout.app')

@section('content')

@include('common.sidebar')

<div class="col-md-9">
    <div class="card">
        <div class="card-header">
            Do you really wants to start new exam?
        </div>
        <div class="card-body">
            @if ($exam_exists)
                <p style="color:red;"><strong>Note:</strong> Your previous exam result will be deleted.</p>
            @endif
            <br>
            <a class="btn btn-success" href="{{ route('student.exam.continue') }}">Start New Exam</a>
        </div>
    </div>
</div>
@endsection