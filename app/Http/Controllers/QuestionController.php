<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Category; // Import model Category

class QuestionController extends Controller
{
    public function index(Request $request)
{
    $query = Question::with('user', 'category');

    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    $questions = $query->latest()->get();

    $categories = Category::all();
    $users = auth()->user();

    return view('questions.index', compact('questions', 'categories', 'users'));
}


public function create()
{
    $categories = Category::all(); // Ambil semua data kategori dari database
    return view('questions.create', compact('categories')); // Berikan data kategori ke view
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'content' => 'required',
        'category_id' => 'required|exists:categories,id', // Pastikan category_id valid
    ]);

    Question::create([
        'title' => $request->title,
        'content' => $request->content,
        'user_id' => auth()->user()->id,
        'category_id' => $request->category_id,
    ]);

    return redirect('/questions');
}

public function show(Question $question)
{
    return view('questions.show', compact('question'));
}

public function filterByCategory($categoryId)
{
    $categories = Category::all();
    $users = auth()->user(); // atau user terkait

    $questions = Question::where('category_id', $categoryId)
                    ->with('user', 'category')
                    ->latest()
                    ->get();

    return view('questions.index', compact('questions', 'categories', 'users'));
}

public function destroy($id)
{
    $question = Question::findOrFail($id);

    // Periksa jika user yang menghapus adalah admin
    if (auth()->user()->role->name === 'admin') {
        // Hapus jawaban yang terkait dengan pertanyaan
        $question->answers()->delete();

        // Hapus pertanyaan
        $question->delete();

        return redirect()->route('questions.index')->with('success', 'Pertanyaan dan jawaban terkait berhasil dihapus.');
    }

    return redirect()->route('questions.index')->with('error', 'Anda tidak memiliki izin untuk menghapus pertanyaan.');
}

}



