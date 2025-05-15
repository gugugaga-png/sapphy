    @extends('layouts.app')

    @section('content')
    <div class="container ">
        <div class="row ">
            <div class="col-12 ">
                <a href="{{ url()->previous() }}" class="btn btn-light mb-4"><i class="bi bi-arrow-left"></i></a>

                <div class="question-details ">
                    <div class="user-info d-flex align-items-start gap-2 mb-2">
                        <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden;">
                            @if($question->user->profile_photo)
                                <img src="{{ asset('storage/' . $question->user->profile_photo) }}" alt="Foto Profil {{ $question->user->name }}"  style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <img src="{{ asset('image/default-avatar.jpg') }}" alt="Default Avatar"  style="width: 100%; height: 100%; object-fit: cover;">
                            @endif
                        </div>
                        <div>
                            <div class="fw-bold">{{ $question->user->name }}</div>
                            <div class="text-muted">{{ $question->category->name }} · {{ $question->created_at->diffForHumans() }}</div>
                        </div>
                    </div>

                    <div class="py-2 px-3  fw-bold fs-4">
                        {{ $question->title }}<br>
                        <div class="fw-normal fs-5 pt-2">{{ $question->content }}</div>
                    </div>
                </div>

                <div class="answer-section mt-4">
                    <h2 class=" ">Jawaban</h2>

                    @foreach ($question->answers as $answer)
                    <div class="answer-card mb-3 p-3 rounded border d-flex">
                        <div class="user-info d-flex align-items-start gap-2 mb-2">
                            <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden;">
                                @if($answer->user->profile_photo)
                                    <img src="{{ asset('storage/' . $answer->user->profile_photo) }}" alt="Foto Profil {{ $answer->user->name }}"  style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <img src="{{ asset('image/default-avatar.jpg') }}" alt="Default Avatar"  style="width: 100%; height: 100%; object-fit: cover;">
                                @endif
                            </div>
                            <div>
                                <div class="fw-bold">{{ $answer->user->name }}</div>
                                <div class="text-muted">{{ $answer->created_at->diffForHumans() }}</div>
                                <div class="py-2 px-3  fs-5 answer-content flex-grow-1">
                                    {{ $answer->content }}
                                </div>
                            </div>

                        </div>

                        @if (auth()->check() && (auth()->user()->id === $answer->user_id || auth()->user()->role->name === 'admin'))
                            <div class="dropdown ms-auto">
                                <button class="btn btn-light text-dark  p-0" type="button" id="dropdownMenuButton{{ $answer->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $answer->id }}">
                                    <li>
                                        <form action="{{ route('answers.destroy', $answer->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jawaban ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item">Hapus</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            @endif
                    </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    @include('questions.answer-form', ['question' => $question])
                </div>

            </div>


        </div>
    </div>



    @endsection
