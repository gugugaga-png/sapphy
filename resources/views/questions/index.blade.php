@extends('layouts.app')

@section('content')

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ajukan pertanyaan baru</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/questions" method="post" class="">
                    @csrf
                    @include('questions.create')
                    <div class="modal-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-dark"><i class="bi bi-send-fill"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-12 col-md-2 d-none d-md-flex flex-column align-items-center order-md-3 mb-4 mb-md-0">
            <div class="" style="width: 100px; height: 100px; overflow: hidden; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                @if(auth()->check() && auth()->user()->profile_photo)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Foto Profil"
                         style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <img src="{{ asset('image/default-avatar.jpg') }}" alt="Default Avatar"
                         style="width: 100%; height: 100%; object-fit: cover;">
                @endif
            </div>
            <div class="fs-2 fw-semibold text-center mt-2">
                Hi, {{ $users->name }}
            </div>
            <button type="button" class="btn btn-dark w-100 mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                + Ajukan Pertanyaan
            </button>
        </div>

        <div class="col-12 col-md-2 order-md-1">
            <div class="d-md-none mb-4">
                <select class="form-select" onchange="if (this.value) window.location.href=this.value;">
                    <option value="#" disabled selected>Pilih Kategori soal yang dicari</option>
                    <option value="{{ route('questions.index') }}">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ route('categories.filter', $category->id) }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="d-none d-md-block">
                <h2 class="h5 fw-semibold mb-3">Kategori</h2>
                <ul class="list-group">
                    <a href="{{ route('questions.index') }}" class="fs-3 p-2 text-decoration-none text-dark">
                        Semua Kategori
                    </a>
                    @foreach ($categories as $category)
                        <a href="{{ route('categories.filter', $category->id) }}" class="fs-3 p-2 text-decoration-none text-dark">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-12 col-md-8 order-md-2">
            @if(request('search'))
                <div class="">
                    Menampilkan hasil untuk: <strong>{{ request('search') }}</strong>
                </div>
            @endif
            @foreach ($questions as $question)
                <div class="card border-0 mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="mb-2 text-muted small d-flex align-items-center gap-2 justify-content-between fs-4 fw-light">
                            <span>{{ $question->user->name }} · {{ $question->created_at->diffForHumans() }}</span>
                            <span class="badge bg-azure-lt px-1 fs-lg-4 fs-sm-6 fs-md-5">{{ $question->category->name }}</span>
                        </div>
                        <h5 class="card-title fs-2">{{ $question->title }}</h5>
                        <div class="text-end">
                            <a href="/questions/{{ $question->id }}" class="btn btn-dark btn-sm">Jawab</a>
                            @if(auth()->user()->role->name === 'admin')
                                <form action="{{ route('questions.destroy', $question->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light bg-red-lt btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<button type='button' class="btn btn-dark btn-md position-fixed bottom-0 end-0 m-4 rounded-pill shadow-lg d-md-none" data-bs-toggle="modal" data-bs-target="#exampleModal">
    + Ajukan Pertanyaan
</button>
@endsection
