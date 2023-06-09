@extends('layout.app')

@section('content')

@include('common.sidebar')

<div class="col-md-9">
    <div class="card">
        <div class="card-header">
            Exam Result
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Student Name</th>
                    <th scope="col">Exam Result</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $marks = 0;
                        $total_marks = 0;
                    @endphp
                    @forelse ($exam_results as $key => $exam_result)
                        <tr>
                            <th scope="row">{{ ++$key }}</th>
                            <th scope="row">{{ $exam_result->name }}</th>
                            <td>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>Correct Answer</th>
                                            <th>Given Answer</th>
                                            <th>Marks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($exam_result->userexam->exams as $result)
                                        @php
                                            $qst_marks = 0;
                                        @endphp
                                        <tr>
                                            <td>{{ $result->question->question }}</td>
                                            <td>
                                                @foreach ($result->question->answers as $answer)
                                                    @if ($answer->is_correct)
                                                        <span class="badge badge-success">{{ $answer->answer }}</span>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($result->question->answers as $answer)
                                                    @if ($result->answer_id == $answer->id)
                                                        @if ($answer->is_correct)
                                                            @php
                                                                $qst_marks += $result->question->question_marks
                                                            @endphp
                                                            <span class="badge badge-success">{{ $answer->answer }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ $answer->answer }}</span>
                                                        @endif
                                                    @endif
                                                @endforeach

                                                @php
                                                    $total_marks += $result->question->question_marks
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $marks += $qst_marks
                                                @endphp
                                                {{ $qst_marks }}/{{ $result->question->question_marks }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2" class="text-right">Total Marks:</th>
                                            <th class="text-right">{{ $marks }}/{{ $total_marks }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No result found!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection