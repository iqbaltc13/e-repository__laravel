@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Tambah Author untuk Jurnal: {{ $journal->journal_name }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('journal-authors.store', $journal) }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">Nama Depan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                       id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Nama Belakang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                       id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="institution" class="form-label">Institusi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('institution') is-invalid @enderror"
                               id="institution" name="institution" value="{{ old('institution') }}" required>
                        @error('institution')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Nama institusi tempat author bekerja atau belajar.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="order" class="form-label">Urutan Author <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror"
                                       id="order" name="order" value="{{ old('order', $journal->coAuthors()->count() + 1) }}"
                                       min="1" required>
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Urutan author dalam daftar penulis (1 = author pertama).</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input @error('is_corresponding') is-invalid @enderror"
                                           type="checkbox" id="is_corresponding" name="is_corresponding" value="1"
                                           {{ old('is_corresponding') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_corresponding">
                                        <strong>Author Corresponding</strong>
                                    </label>
                                    @error('is_corresponding')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted d-block">
                                        Centang jika author ini adalah corresponding author (author penanggungjawab).
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Informasi:</strong> Author akan ditambahkan ke jurnal "{{ $journal->journal_name }}".
                        Pastikan data sudah benar sebelum menyimpan.
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('journal-authors.index', $journal) }}" class="btn btn-secondary me-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Author
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
