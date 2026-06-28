@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard</h4>

    {{-- Statistik --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card text-white bg-primary h-100">
                <div class="card-body text-center">
                    <i class="bi bi-journal-text fs-2"></i>
                    <h3>{{ $total }}</h3>
                    <p class="mb-0">Total Catatan</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-white bg-warning h-100">
                <div class="card-body text-center">
                    <i class="bi bi-pin-angle fs-2"></i>
                    <h3>{{ $pinned }}</h3>
                    <p class="mb-0">Disematkan</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-white bg-danger h-100">
                <div class="card-body text-center">
                    <i class="bi bi-heart fs-2"></i>
                    <h3>{{ $favorites }}</h3>
                    <p class="mb-0">Favorit</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-white bg-success h-100">
                <div class="card-body text-center">
                    <i class="bi bi-tag fs-2"></i>
                    <h3>{{ $categories }}</h3>
                    <p class="mb-0">Kategori</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        {{-- Catatan Terbaru --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-clock-history"></i> Catatan Terbaru</span>
                    <a href="{{ route('notes.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($recent as $note)
                            <a href="{{ route('notes.edit', $note->id) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between">
                                    <span>
                                        {{ $note->title }}
                                        @if($note->is_pinned) <i class="bi bi-pin-angle text-warning"></i> @endif
                                        @if($note->is_favorite) <i class="bi bi-heart-fill text-danger"></i> @endif
                                    </span>
                                    <small class="text-muted">{{ $note->updated_at->diffForHumans() }}</small>
                                </div>
                                <small class="text-muted">{{ Str::limit($note->content, 60) }}</small>
                            </a>
                        @empty
                            <div class="list-group-item text-center text-muted">Belum ada catatan.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Info Sampah --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><i class="bi bi-trash"></i> Tempat Sampah</div>
                <div class="card-body text-center">
                    <h3 class="text-danger">{{ $trash }}</h3>
                    <p class="text-muted">Catatan dihapus</p>
                    <a href="{{ route('notes.trash') }}" class="btn btn-outline-danger btn-sm">Kelola Sampah</a>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header"><i class="bi bi-plus-circle"></i> Aksi Cepat</div>
                <div class="card-body">
                    <a href="{{ route('notes.create') }}" class="btn btn-primary w-100 mb-2">
                        <i class="bi bi-plus"></i> Tambah Catatan
                    </a>
                    <a href="{{ route('notes.index') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-search"></i> Cari Catatan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
