@extends('layout.app')

@section('content')

<div class="col-md-8 offset-md-2">
    <legend>MCQ's EXAM</legend>
    <br>
    @if (!empty($question))
        <form action="{{ route('student.answer.store') }}" id="addAnswer" method="post">
            @csrf
            <input type="hidden" name="userexam_id" value="{{ session('userexam_id') }}">
            <input type="hidden" name="question_id" value="{{ $question->id }}">
            <input type="hidden" name="user_answer_id" value="">

            <div class="card">
                <div class="card-header">
                    Q #{{ request()->session()->get('next_qst') }}. {{ $question->question }}
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($question->answers as $key => $answer)
                            <li class="list-group-item">{{ ++$key }}). {{ $answer->answer }} &nbsp;<input type="radio" name="user_answer" class="answers" value="{{ $answer->id }}"></li>
                        @endforeach
                    </ul>
                    <p class="error" style="color:red;"></p>
                    <br>
                    <button type="submit" class="btn btn-success" style="float:right;background:green;">Next</button>
                </div>
            </div>
        </form>
    @else
        <h1>NO EXAM PUBLISHED YET..! <a href="{{ route('student.dashboard') }}" class="btn btn-success">Back to Dashboard</a></h1>
    @endif
</div>
<script>
    $(document).ready(function() {
        $('#addAnswer').submit(function(e) {
            e.preventDefault();

            var userAnswer = false;

            for (let i = 0; i < $('.answers').length; i++) {
                if ($('.answers:eq("'+ i +'")').prop('checked') == true) {

                    // now get the text value from answer input field and put it in the radio value
                    $('.answers:eq("'+ i +'")').val( $('.answers:eq("'+ i +'")').closest('.input-group').find('input').val());

                    // and make the iscorrect, if anyone of radio is selected
                    userAnswer = true;
                }
                
                if (userAnswer) {
                    // Submit the form
                    document.getElementById("addAnswer").submit();
                    break;
                } else {
                    $('.error').text('Please select any correct answer!');
                }
            }
        });

        $('.answers').click(function() {
            $('input[name=user_answer_id]').val($(this).val());
        }); 
    });
</script>
@endsection