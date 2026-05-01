<!DOCTYPE html>
<html>
<head>
    <title>Edit Note</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="mb-4">✏️ Edit Note</h2>

        <form action="{{ route('notes.update', $note->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Judul -->
            <div class="mb-3">
                <label class="form-label">Judul</label>
                <input type="text" name="title"
                    value="{{ old('title', $note->title) }}"
                    class="form-control">
            </div>

            <!-- Isi -->
            <div class="mb-3">
                <label class="form-label">Isi</label>
                <textarea name="content" class="form-control">{{ old('content', $note->content) }}</textarea>
            </div>

            <!-- Kategori -->
            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <input type="text" name="category"
                    value="{{ old('category', $note->category) }}"
                    class="form-control">
            </div>

            <!-- Hidden input (INI KUNCI FIX CHECKBOX) -->
            <input type="hidden" name="is_pinned" value="0">

            <!-- Checkbox -->
            <div class="form-check mb-3">
                <input type="checkbox" name="is_pinned" value="0"
                    class="form-check-input"
                    {{ old('is_pinned', $note->is_pinned) ? 'checked' : '' }}>
                <label class="form-check-label">⭐ Pin Note</label>
            </div>

            <!-- Tombol -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('notes.index') }}" class="btn btn-secondary">Kembali</a>
                <button class="btn btn-primary">Update</button>
            </div>

        </form>
    </div>
</div>

</body>
</html>