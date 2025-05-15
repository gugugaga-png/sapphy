<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
{
    // Memastikan hanya admin yang bisa mengakses
    if (auth()->user()->role->name !== 'admin') {
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }

    // Mengambil kata kunci pencarian dari query string
    $search = $request->input('search');

    // Mengambil kategori dengan hitung pertanyaan terkait dan pencarian jika ada
    $categories = Category::withCount('questions')
        ->when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
        ->paginate(10);  // Menambahkan paginasi untuk pembatasan jumlah kategori per halaman

    // Menampilkan daftar kategori ke view
    return view('categories.index', compact('categories'));
}

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories',
        ]);

        Category::create([
            'name' => $request->name,
        ]);


        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }
    public function destroy($id)
{
    $category = Category::findOrFail($id);

    foreach ($category->questions as $question) {
        // Hapus jawaban dulu
        $question->answers()->delete();
        // Lalu hapus pertanyaan
        $question->delete();
    }

    // Terakhir hapus kategori
    $category->delete();

    return redirect()->back()->with('success', 'Kategori, pertanyaan, dan semua jawaban berhasil dihapus.');
}

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|unique:categories,name,' . $id,
    ]);

    $category = Category::findOrFail($id);
    $category->update([
        'name' => $request->name,
    ]);

    return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
}

    

}
