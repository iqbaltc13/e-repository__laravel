@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Kategori: {{ $journalCategory->name }}</h5>
                <div>
                    <a href="{{ route('journal-categories.edit', $journalCategory) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Edit Kategori
                    </a>
                    <a href="{{ route('journal-categories.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h6>Deskripsi</h6>
                        <p class="text-muted">{{ $journalCategory->description ?: 'Tidak ada deskripsi.' }}</p>
                    </div>
                    <div class="col-md-4">
                        <h6>Informasi</h6>
                        <table class="table table-sm">
                            <tr>
                                <td>Slug:</td>
                                <td><code>{{ $journalCategory->slug }}</code></td>
                            </tr>
                            <tr>
                                <td>Jumlah Jurnal:</td>
                                <td><span class="badge bg-info">{{ $journals->total() }}</span></td>
                            </tr>
                            <tr>
                                <td>Dibuat:</td>
                                <td>{{ $journalCategory->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td>Diupdate:</td>
                                <td>{{ $journalCategory->updated_at->format('d M Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jurnal dalam kategori ini -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Jurnal dalam Kategori "{{ $journalCategory->name }}"</h5>
            </div>
            <div class="card-body">
                @if($journals->count() > 0)
                    <div class="row">
                        @foreach($journals as $journal)
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <a href="{{ route('journals.show', $journal) }}" class="text-decoration-none">
                                                {{ $journal->journal_name }}
                                            </a>
                                        </h6>
                                        <p class="card-text">
                                            {{ Str::limit($journal->abstract, 100) }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-user"></i> {{ $journal->author->fullname }}
                                            </small>
                                            <span class="badge bg-{{ $journal->status === 'published' ? 'success' : 'warning' }}">
                                                {{ ucfirst($journal->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $journals->links() }}
                    </div>
                @else
                    <div class="text-center text-muted">
                        <i class="fas fa-folder-open fa-3x mb-3"></i>
                        <p>Belum ada jurnal dalam kategori ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
