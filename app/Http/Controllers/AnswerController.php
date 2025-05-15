<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;


class AnswerController extends Controller
{
    public function store(Request $request, Question $question)
{
    $request->validate([
        'content' => 'required',
        'question_id' => 'required|exists:questions,id', // Pastikan question_id ada di tabel questions
    ]);

    Answer::create([
        'content' => $request->content,
        'question_id' => $request->question_id,
        'user_id' => auth()->id()
    ]);

    


    return back()->with('success', 'Jawaban berhasil ditambahkan.');
}

    public function destroy($id)
    {
        $answer = Answer::findOrFail($id);

        // Pastikan hanya pemilik jawaban atau admin yang bisa menghapus
        if (auth()->user()->id !== $answer->user_id && !auth()->user()->is_admin) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus jawaban ini.');
        }

        $answer->delete();
        return redirect()->back()->with('success', 'Jawaban berhasil dihapus.');
    }
}
