@extends('layouts.app')

@section('content')
<div class="container py-3">
    {{-- Tambahkan di dalam kontainer, di luar elemen .page-header --}}
 @if(auth()->user()->role->name === 'admin')
    <button type="button" class="btn btn-dark mb-3 shadow" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
        <i class="bi bi-plus"></i> Tambah Kategori
    </button>
    @endif

    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="page-title">Daftar Kategori</h1>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('categories.index') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari kategori..." value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="ti ti-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-vcenter">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Kategori</th>
                            <th>Jumlah Pertanyaan</th>
                            @if(auth()->user()->role->name === 'admin')
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $index => $category)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->questions_count }}</td>
                                @if(auth()->user()->role->name === 'admin')
                                    <td>
                                        <div class="d-flex flex-wrap gap-2">
                                            <button type="button"
                                                    class="btn btn-sm btn-light bg-yellow-lt"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editCategoryModal{{ $category->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('categories.destroy', $category->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus kategori ini beserta semua pertanyaannya?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light bg-red-lt ">
                                                <i class="bi bi-trash"></i>
                                        </button>
                                </form>
                            </div>
                        </td>
                    @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role->name === 'admin' ? 4 : 3 }}" class="text-center text-muted">
                            Tidak ada kategori.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            </div>

            <div class="mt-4">
                {{ $categories->appends(['search' => request('search'), 'per_page' => request('per_page')])->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>


    @if(auth()->user()->role->name === 'admin')
    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCategoryModalLabel">Buat Kategori Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('categories.create')
                </div>
            </div>
        </div>
    </div>

    @foreach ($categories as $category)
        <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">Edit Kategori</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name{{ $category->id }}" class="form-label">Nama Kategori</label>
                                <input type="text" name="name" class="form-control" id="name{{ $category->id }}" value="{{ $category->name }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    @endif
</div>
@endsection
