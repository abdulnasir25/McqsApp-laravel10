<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::where('user_id', Auth::id())->with('answers')->get();

        return view('admin.questions_list', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.question_form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // insert a record and then retrieve the ID:
        $question_id = Question::create([
            'user_id' => Auth::id(),
            'question' => $request->question,
            'question_marks' => !empty($request->question_marks) ? $request->question_marks : 0
        ])->id;

        foreach ($request->answers as $answer) {
            $is_correct = 0;
            
            if ($request->correct == $answer) {
                $is_correct = 1;
            }
            
            Answer::create([
                'question_id' => $question_id,
                'answer' => $answer,
                'is_correct' => $is_correct
            ]);
        }

        return redirect()->route('questions.index')->with('status', 'Question added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $question = Question::where('id', $id)->with('answers')->firstOrFail();

        return view('admin.question_edit_form', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // insert a record and then retrieve the ID:
        Question::where('id', $id)->update([
            'question' => $request->question
        ]);

        // find and delete before prev record and re-enter
        Answer::where('question_id', $id)->delete();

        foreach ($request->answers as $answer) {
            $is_correct = 0;
            
            if ($request->correct == $answer) {
                $is_correct = 1;
            }
            
            Answer::insert([
                'question_id' => $id,
                'answer' => $answer,
                'is_correct' => $is_correct
            ]);
        }

        return redirect()->route('questions.index')->with('status', 'Question updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Question::whereId($id)->delete();
        Answer::where('question_id', $id)->delete();

        return back()->with('status', 'Deleted successfully!');
    }
}
