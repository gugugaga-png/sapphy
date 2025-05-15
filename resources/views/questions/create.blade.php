
<div class="mb-3">
    <label for="title" class="form-label">Judul</label>
    <input type="content" name="title" id="title" class="form-control" placeholder="Masukkan judul pertanyaan" required>
</div>

<div class="mb-3">
    <label for="content" class="form-label">Isi Pertanyaan</label>
    <textarea name="content" id="content" class="form-control" rows="4" placeholder="Tulis isi pertanyaan kamu" required></textarea>
</div>

<div class="mb-3">
    <label for="category_id" class="form-label">Kategori</label>
    <select name="category_id" id="category_id" class="form-select">
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>