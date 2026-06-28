@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><i class="bi bi-journal-text"></i> Catatan Saya</h4>
        <a href="{{ route('notes.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah</a>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('notes.index') }}" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="🔍 Cari catatan..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="category" class="form-select">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="filter" class="form-select">
                <option value="">Semua</option>
                <option value="pinned" {{ request('filter') == 'pinned' ? 'selected' : '' }}>📌 Disematkan</option>
                <option value="favorite" {{ request('filter') == 'favorite' ? 'selected' : '' }}>❤️ Favorit</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="sort" class="form-select">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Judul A-Z</option>
            </select>
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-outline-primary w-100"><i class="bi bi-funnel"></i></button>
        </div>
    </form>

    {{-- Notes Grid --}}
    @if($notes->isEmpty())
        <div class="text-center text-muted py-5">
            <i class="bi bi-journal-x fs-1"></i>
            <p class="mt-2">Tidak ada catatan ditemukan.</p>
            <a href="{{ route('notes.create') }}" class="btn btn-primary">Buat Catatan Pertama</a>
        </div>
    @else
        <div class="row g-3">
            @foreach($notes as $note)
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 shadow-sm">
                        @if($note->image)
                            <img src="{{ Storage::url($note->image) }}" class="card-img-top" style="height:160px; object-fit:cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ $note->title }}
                                @if($note->is_pinned) <i class="bi bi-pin-angle text-warning" title="Disematkan"></i> @endif
                                @if($note->is_favorite) <i class="bi bi-heart-fill text-danger" title="Favorit"></i> @endif
                            </h5>
                            <p class="card-text text-muted">{{ Str::limit($note->content, 80) }}</p>
                            @if($note->category)
                                <span class="badge bg-secondary">{{ $note->category }}</span>
                            @endif
                            <small class="d-block text-muted mt-2">{{ $note->updated_at->diffForHumans() }}</small>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Edit</a>
                            <form action="{{ route('notes.destroy', $note->id) }}" method="POST" class="delete-form">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger btn-delete"><i class="bi bi-trash"></i> Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">{{ $notes->links() }}</div>
    @endif
</div>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">Yakin ingin memindahkan catatan ini ke tempat sampah?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let targetForm = null;
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {
            targetForm = this.closest('form');
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });
    document.getElementById('confirmDelete').addEventListener('click', function () {
        if (targetForm) targetForm.submit();
    });
</script>
@endpush
