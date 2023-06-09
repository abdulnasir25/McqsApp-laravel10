@extends('layout.app')

@section('content')

@include('common.sidebar')

<div class="col-md-9">
    <div class="card">
        <div class="card-header">
            Edit Question
        </div>
        <div class="card-body">
            <form action="{{ route('questions.update', $question->id) }}" id="editQst" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="question" class="form-label">Question Title</label>
                    <input type="text" name="question" value="{{ $question->question }}" class="form-control" id="question" required>
                </div>
                
                <div class="form-group">
                    <label for="question_marks" class="form-label">Question Marks</label>
                    <input type="text" name="question_marks" value="{{ $question->question_marks }}" class="form-control" id="question_marks" required placeholder="10">
                </div>

                <div class="card-header">Add answers to the queston! <button id="addAnswer" style="background:#307083;" type="button" class="ml-5 btn btn-secondary btn-sm">Add Answer</button></div>
                <p class="error" style="color:red;"></p>

                <div class="card-body">
                    <div class="row answers-body">
                        <!-- answer input append here -->
                        @if ($question->answers)
                            @foreach ($question->answers as $answer)
                            <div class="col-md-6 answers">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="answers[]" value="{{ $answer->answer }}" class="form-control" placeholder="Enter answer" required>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Correct ? &nbsp;<input type="radio" name="correct" class="is_correct" {{ $answer->is_correct ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" style="background:red;" class="btn btn-danger btn-sm" onclick="$(this).parent().parent().remove();">Remove</button>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary" style="background:black;">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Submit form
        $('#editQst').submit(function(e) {
            e.preventDefault();

            if($('.answers').length < 2) {
                $('.error').text('Add at least 2 answers!');

                // remove alert text from after 5sec
                setTimeout(function() {
                    $('.error').text('');
                }, 5000);
            } else {
                // if all okay, now need to confirm "Correct" input, if given or not
                
                for (let i = 0; i < $('.is_correct').length; i++) {
                    var isCorrect = false;
                    if ($('.is_correct:eq("'+ i +'")').prop('checked') == true) {

                        // now get the text value from answer input field and put it in the radio value
                        $('.is_correct:eq("'+ i +'")').val( $('.is_correct:eq("'+ i +'")').closest('.input-group').find('input').val());

                        // and make the iscorrect, if anyone of radio is selected
                        isCorrect = true;
                    }
                    
                    if (isCorrect) {
                        // Submit the form
                        document.getElementById("editQst").submit();
                        return false;
                    } else {
                        $('.error').text('Please select anyone answer is correct!');

                        // remove alert text from after 5sec
                        setTimeout(function() {
                            $('.error').text('');
                        }, 3000);
                    }
                }
            }
        });

        // add answer field dynamically
        $('#addAnswer').click(function() {
            // add check to see, if answers isn't more than 6.
            if($('.answers').length >= 6) {
                $('.error').text('Maximum 6 answers are allowed!');

                // remove alert text from after 5sec
                setTimeout(function() {
                    $('.error').text('');
                }, 5000);
            } else {
                var html = `
                    <div class="col-md-6 answers">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" name="answers[]" class="form-control" placeholder="Enter answer" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        Correct ? &nbsp;<input type="radio" name="correct" class="is_correct">
                                    </div>
                                </div>
                            </div>
                            <button type="button" style="background:red;" class="btn btn-danger btn-sm" onclick="$(this).parent().parent().remove();">Remove</button>
                        </div>
                    </div>
                `;

                // append it to answer body div
                $('.answers-body').append(html);
            }
        });
    });
</script>
@endsection