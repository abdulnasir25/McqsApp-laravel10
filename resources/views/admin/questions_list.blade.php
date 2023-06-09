@extends('layout.app')

@section('content')

@include('common.sidebar')

<div class="col-md-9">
    @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            Questions List <a class="btn btn-primary right" href="{{ route('questions.create') }}">Add New Question</a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Question Title</th>
                    <th scope="col">Answers</th>
                    <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($questions as $key => $question)
                        <tr>
                            <th scope="row">{{ ++$key }}</th>
                            <td>{{ $question->question }}</td>
                            <td>
                                <ul class="list-group">
                                @foreach ($question->answers as $key => $answer)
                                    <li class="list-group-item">{{ ++$key }} - {{ $answer->answer }} &nbsp;{!! $answer->is_correct ? '<span class="badge badge-success">Correct Answer<span>' : '' !!}</li>
                                @endforeach
                                </ul>
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ route('questions.edit', $question->id) }}">Edit</a> 
                                <form action="{{ route('questions.destroy', $question->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" style="background:red;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No result found!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection