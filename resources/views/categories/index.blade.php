@extends('layouts.app')

@section('content')
<div class="container py-3">
    {{-- Tambahkan di dalam kontainer, di luar elemen .page-header --}}
@if(auth()->user()->role->name === 'admin')
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
        <button type="button" class="btn btn-dark shadow rounded-circle" 
                data-bs-toggle="modal" data-bs-target="#createCategoryModal"
                style="width: 60px; height: 60px;">
            <i class="bi bi-plus fs-4"></i>
        </button>
    </div>
@endif


    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="page-title">Daftar Kategori</h1>
    </div>

    <div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('categories.index') }}">
            <div class="row g-2 align-items-center">
                <div class="col-12 col-md-9">
                    <input type="text" name="search" class="form-control" placeholder="Cari kategori..." value="{{ request('search') }}">
                </div>
                <div class="col-12 col-md-3 d-grid">
                    <button class="btn btn-dark" type="submit">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                </div>
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
                <th class="text-end">Aksi</th>
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
                    <td class="text-end">
                        <div class="dropdown">
                            <button class="btn btn-light text-dark p-0" type="button" id="dropdownMenuButton{{ $category->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $category->id }}">
                                <li>
                                    <button type="button"
                                        class="dropdown-item"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editCategoryModal{{ $category->id }}">
                                        Edit
                                    </button>
                                </li>
                                <li>
                                    <form action="{{ route('categories.destroy', $category->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus kategori ini beserta semua pertanyaannya?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">Hapus</button>
                                    </form>
                                </li>
                            </ul>
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
