<!DOCTYPE html>
<html>
<head>
    <title>Tambah Note</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2>Tambah Note</h2>

    <form action="{{ route('notes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Isi</label>
            <textarea name="content" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <input type="text" name="category" class="form-control">
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_pinned" value="1" class="form-check-input">
            <label class="form-check-label">Pin Note</label>
        </div>

        <button class="btn btn-success">Simpan</button>
    </form>
</div>

</body>
</html>