@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 700px;">
    <div class="card shadow">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Catatan</h5>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('notes.update', $note->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Judul <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $note->title) }}" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Isi <span class="text-danger">*</span></label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="5" required>{{ old('content', $note->content) }}</textarea>
                    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="category" class="form-control" list="categoryList"
                        value="{{ old('category', $note->category) }}" placeholder="Contoh: Pekerjaan, Pribadi...">
                    <datalist id="categoryList">
                        @foreach($categories as $cat)<option value="{{ $cat }}">@endforeach
                    </datalist>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar</label>
                    @if($note->image)
                        <div class="mb-2">
                            <img src="{{ Storage::url($note->image) }}" class="img-thumbnail" style="max-height:150px;">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <div class="form-check">
                            <input type="checkbox" name="is_pinned" value="1" class="form-check-input" id="isPinned"
                                {{ old('is_pinned', $note->is_pinned) ? 'checked' : '' }}>
                            <label class="form-check-label" for="isPinned"><i class="bi bi-pin-angle text-warning"></i> Sematkan</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input type="checkbox" name="is_favorite" value="1" class="form-check-input" id="isFavorite"
                                {{ old('is_favorite', $note->is_favorite) ? 'checked' : '' }}>
                            <label class="form-check-label" for="isFavorite"><i class="bi bi-heart text-danger"></i> Favorit</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('notes.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
