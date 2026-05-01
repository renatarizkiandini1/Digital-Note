<!DOCTYPE html>
<html>
<head>
    <title>Digital Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1 class="mb-4 text-center">📒 Digital Notes</h1>

    <div class="text-end mb-3">
        <a href="{{ route('notes.create') }}" class="btn btn-primary">+ Tambah Note</a>
    </div>

    <div class="row">
        @foreach($notes as $note)
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">

                        <h5 class="card-title">
                            {{ $note->title }}
                            @if($note->is_pinned)
                                <span class="text-warning">⭐</span>
                            @endif
                        </h5>

                        <p class="card-text">{{ $note->content }}</p>

                        <span class="badge bg-secondary">
                            {{ $note->category ?? 'Umum' }}
                        </span>

                        <div class="mt-3 d-flex justify-content-between">
                            <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('notes.destroy', $note->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>