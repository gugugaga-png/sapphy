<form action="{{ route('answers.store') }}" method="POST" class="bg-light p-2 d-flex align-items-center rounded-pill shadow-sm" style="border: 1px solid #e0e0e0;">
    @csrf
    <div class="flex-grow-1">
    <input type="hidden" name="question_id" value="{{ $question->id }}">
    <input
        type="text"
        name="content"
        id="chatInput"
        class="form-control flex-grow-1 rounded-pill border-0 bg-transparent"
        placeholder="Tulis jawaban Anda..."
        aria-label="Tulis jawaban Anda"
        required
    >
</div>
    <button
        type="submit"
        class="btn btn-dark rounded-circle p-2 ms-2 d-flex align-items-center justify-content-center"
        aria-label="Kirim jawaban"
        style="width: 40px; height: 40px; min-width: unset;"
    >
        <i class="bi bi-arrow-right" style="font-size: 1rem;"></i>
    </button>
</form>

