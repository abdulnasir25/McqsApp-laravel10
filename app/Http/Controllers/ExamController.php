<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use App\Models\User;
use App\Models\UserExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function exam()
    {
        $exam_exists = UserExam::where('user_id', Auth::id())->exists();

        return view('student.exam', compact('exam_exists'));
    }
    
    public function startExam()
    {
        // A user can submit multiple exams (just change the relationship in User model), but this time, I prefer to go with one.
        // &
        // Delete previous exam record to prevent duplication for the same user.
        $userexam = UserExam::where('user_id', Auth::id())->first();
        if (!empty($userexam)) {
            // for unknows reason the relationship deleting event not working,
            // so I followed this way, to save my time.
            Exam::where('exam_id', $userexam->id)->delete();
            $userexam->delete();
        }

        // save new record and get exam id.
        $userexam_id = UserExam::create([
                                    'user_id' => Auth::id()
                                ])->id;

        // set the session for next question, because we will use it.
        session(['next_qst' => '1']);
        // also, keep the exam id as well
        session(['userexam_id' => $userexam_id]);

        $question = Question::first();
     
        return view('student.exam_continue', compact('question'));
    }
    
    public function storeAnswer(Request $request)
    {
        Exam::insert([
            'exam_id' => $request->userexam_id,
            'question_id' => $request->question_id,
            'answer_id' => $request->user_answer_id
        ]);
        
        $next_qst = session('next_qst');
        $next_qst += 1;

        // update the value of session
        session(['next_qst' => $next_qst]);

        // fetch all questions
        $questions = Question::all();
        
        $i = 0;
        foreach ($questions as $question) {
            $i++;

            // check if count questions are less than number of submited question ($next_qst).
            // when $next_qst become greater, then end the exam.
            if ($questions->count() < $next_qst) {
                return redirect()->route('student.exam.finished');
            }

            // if $i becomes equal to $next_qst, then return question view.
            // and the loop will stop and return a view.
            if ($i == $next_qst) {
                return view('student.exam_continue', compact('question'));
            }
        }
    }

    public function examFinished()
    {
        return view('student.exam_finished');
    }

    // Student get has result
    public function examResult()
    {
        $exams_attempted = UserExam::where('user_id', Auth::id())->with(['exams.question.answers'])->get();
        
        return view('student.exam_result', compact('exams_attempted'));
    }

    // Admin get all result
    public function getExamResults()
    {
        $exam_results = User::where('id', '!=', Auth::id())->with(['userexam.exams.question.answers'])->get();
        
        return view('admin.exam_results_list', compact('exam_results'));
    }
}
