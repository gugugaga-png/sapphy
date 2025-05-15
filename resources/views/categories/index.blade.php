<!-- categories/index.blade.php -->

@extends('layouts.app')

@section('content')

<div class="container py-3">
    <h1 class="text-3xl font-bold mb-3">Daftar Kategori</h1>

    <!-- Form Pencarian -->
    <form method="GET" action="{{ route('categories.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari kategori..." value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Cari</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
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
                                <!-- Tombol Edit dengan ikon -->
                               <div class="btn-group">
                                <button type="button" class="btn btn-md btn-light bg-yellow-lt" data-bs-toggle="modal" data-bs-target="#editCategory{{ $category->id }}">
                                    <i class="bi bi-pencil-square"></i> 
                                </button>

                                <!-- Tombol Hapus dengan ikon -->
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini beserta semua pertanyaannya?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-md btn-light bg-red-lt">
                                        <i class="bi bi-trash"></i> 
                                    </button>
                                </form>

                               </div>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editCategory{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryLabel{{ $category->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editCategoryLabel{{ $category->id }}">Edit Kategori</h5>
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
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
            
            
            
            
        </table>
        
    </div>
    <div class="mt-4">
        <!-- Paginasi dengan CSS Bootstrap -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                {{ $categories->appends(['search' => request('search'), 'per_page' => request('per_page')])->links('pagination::bootstrap-5') }}
            </ul>
        </nav>
    </div>

    @if(auth()->user()->role->name === 'admin')
    <!-- Tombol Tambah Kategori -->
    <div class="d-flex justify-content-end mb-3 pt-5">
        <button type="button" class="btn bg-teal-lt btn-light" data-bs-toggle="modal" data-bs-target="#catagory">
            + Category
        </button>
    </div>

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="catagory" tabindex="-1" aria-labelledby="catagoryLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="catagoryLabel">Buat Category Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('categories.create')
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection
