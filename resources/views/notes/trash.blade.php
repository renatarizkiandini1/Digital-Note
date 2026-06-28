@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><i class="bi bi-trash"></i> Tempat Sampah</h4>
        <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    @if($notes->isEmpty())
        <div class="text-center text-muted py-5">
            <i class="bi bi-trash fs-1"></i>
            <p class="mt-2">Tempat sampah kosong.</p>
        </div>
    @else
        <div class="row g-3">
            @foreach($notes as $note)
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 border-danger shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $note->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($note->content, 80) }}</p>
                            @if($note->category)
                                <span class="badge bg-secondary">{{ $note->category }}</span>
                            @endif
                            <small class="d-block text-muted mt-2">Dihapus {{ $note->deleted_at->diffForHumans() }}</small>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <form action="{{ route('notes.restore', $note->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-success"><i class="bi bi-arrow-counterclockwise"></i> Pulihkan</button>
                            </form>
                            <form action="{{ route('notes.force-delete', $note->id) }}" method="POST" class="delete-form">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger btn-delete"><i class="bi bi-x-circle"></i> Hapus Permanen</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $notes->links() }}</div>
    @endif
</div>

{{-- Modal Konfirmasi --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Permanen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">Catatan akan dihapus permanen dan tidak bisa dipulihkan. Lanjutkan?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Hapus Permanen</button>
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
