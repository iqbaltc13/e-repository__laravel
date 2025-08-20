@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Tambah Jurnal Baru</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('journals.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Basic Information -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="journal_name" class="form-label">Nama Jurnal <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('journal_name') is-invalid @enderror"
                                       id="journal_name" name="journal_name" value="{{ old('journal_name') }}" required>
                                @error('journal_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('category_id') is-invalid @enderror"
                                        id="category_id" name="category_id" >
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="abstract" class="form-label">Abstrak <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('abstract') is-invalid @enderror"
                                  id="abstract" name="abstract" rows="6" required>{{ old('abstract') }}</textarea>
                        @error('abstract')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="keywords" class="form-label">Kata Kunci <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('keywords') is-invalid @enderror"
                                  id="keywords" name="keywords" rows="2" required>{{ old('keywords') }}</textarea>
                        @error('keywords')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Pisahkan kata kunci dengan koma (,)</small>
                    </div>

                    <!-- Institution Information -->
                    <h6 class="mb-3 mt-4">Informasi Institusi</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="institution_code" class="form-label">Universitas <span class="text-danger">*</span></label>
                                <select class="form-select @error('institution_code') is-invalid @enderror"
                                        id="institution_code" name="institution_code" required>
                                    <option value="">Pilih Universitas</option>
                                    @foreach($institutions as $institution)
                                        <option value="{{ $institution->institution_code }}"
                                                {{ old('institution_code') == $institution->institution_code ? 'selected' : '' }}>
                                            {{ $institution->institution_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('institution_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="faculty_code" class="form-label">Fakultas <span class="text-danger">*</span></label>
                                <select class="form-select @error('faculty_code') is-invalid @enderror"
                                        id="faculty_code" name="faculty_code" >
                                    <option value="">Pilih Fakultas</option>
                                    @foreach($faculties as $faculty)
                                        <option value="{{ $faculty->faculty_code }}"
                                                {{ old('faculty_code') == $faculty->faculty_code ? 'selected' : '' }}>
                                            {{ $faculty->faculty_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('faculty_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="department_code" class="form-label">Departemen/Prodi <span class="text-danger">*</span></label>
                                <select class="form-select @error('department_code') is-invalid @enderror"
                                        id="department_code" name="department_code" >
                                    <option value="">Pilih Departemen/Prodi</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->department_code }}"
                                                {{ old('department_code') == $department->department_code ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="institution" class="form-label">Nama Institusi Pengaju <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('institution') is-invalid @enderror"
                               id="institution" name="institution" value="{{ old('institution') }}" required>
                        @error('institution')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Publication Details -->
                    <h6 class="mb-3 mt-4">Detail Publikasi</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="doi" class="form-label">DOI</label>
                                <input type="text" class="form-control @error('doi') is-invalid @enderror"
                                       id="doi" name="doi" value="{{ old('doi') }}" placeholder="10.xxxx/xxxxxx">
                                @error('doi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="issn" class="form-label">ISSN</label>
                                <input type="text" class="form-control @error('issn') is-invalid @enderror"
                                       id="issn" name="issn" value="{{ old('issn') }}" placeholder="XXXX-XXXX">
                                @error('issn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="publisher" class="form-label">Penerbit</label>
                                <input type="text" class="form-control @error('publisher') is-invalid @enderror"
                                       id="publisher" name="publisher" value="{{ old('publisher') }}">
                                @error('publisher')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="pages_start" class="form-label">Halaman Awal</label>
                                <input type="number" class="form-control @error('pages_start') is-invalid @enderror"
                                       id="pages_start" name="pages_start" value="{{ old('pages_start') }}" min="1">
                                @error('pages_start')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="pages_end" class="form-label">Halaman Akhir</label>
                                <input type="number" class="form-control @error('pages_end') is-invalid @enderror"
                                       id="pages_end" name="pages_end" value="{{ old('pages_end') }}" min="1">
                                @error('pages_end')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="language" class="form-label">Bahasa <span class="text-danger">*</span></label>
                                <select class="form-select @error('language') is-invalid @enderror"
                                        id="language" name="language" required>
                                    <option value="id" {{ old('language') == 'id' ? 'selected' : '' }}>Indonesia</option>
                                    <option value="en" {{ old('language') == 'en' ? 'selected' : '' }}>English</option>
                                    <option value="es" {{ old('language') == 'es' ? 'selected' : '' }}>Español</option>
                                    <option value="fr" {{ old('language') == 'fr' ? 'selected' : '' }}>Français</option>
                                    <option value="de" {{ old('language') == 'de' ? 'selected' : '' }}>Deutsch</option>
                                </select>
                                @error('language')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status" name="status" required>
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="submitted" {{ old('status', 'submitted') == 'submitted' ? 'selected' : '' }}>Submitted</option>
                                    <option value="under_review" {{ old('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                                    <option value="accepted" {{ old('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- File Upload -->
                    <h6 class="mb-3 mt-4">Update Link File <small class="text-muted">(Opsional - kosongkan jika tidak ingin mengubah)</small></h6>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="pdf_file" class="form-label">File PDF Jurnal Baru</label>
                                <input type="text" class="form-control @error('pdf_file') is-invalid @enderror"
                                       id="pdf_file" name="pdf_file" value="">
                                @error('pdf_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Format: Link PDF. Abaikan jika tidak ingin mengubah file.</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="other_document_file" class="form-label">Dokumen Pendukung Baru</label>
                                <textarea class="form-control @error('other_document_file') is-invalid @enderror"
                                       id="other_document_file" name="other_document_file" rows="3">

                                    </textarea>
                                @error('other_document_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Pisahkan link dokumen pendukung dengan Pipe (|)</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('journals.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Jurnal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
