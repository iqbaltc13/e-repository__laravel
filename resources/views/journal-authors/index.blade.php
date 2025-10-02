@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Journal Info -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-book"></i> {{ $journal->journal_name }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <p class="mb-2"><strong>Abstrak:</strong> {{ Str::limit($journal->abstract, 200) }}</p>
                        <p class="mb-2"><strong>Kata Kunci:</strong> {{ $journal->keywords }}</p>
                        <p class="mb-0">
                            <strong>Status:</strong>
                            <span class="badge bg-{{ $journal->status === 'published' ? 'success' : 'warning' }}">
                                {{ ucfirst($journal->status) }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1"><strong>Penulis Utama:</strong> {{ $journal->author->fullname }}</p>
                        <p class="mb-1"><strong>Kategori:</strong> {{ $journal->category->name }}</p>
                        <p class="mb-1"><strong>Fakultas:</strong> {{ $journal->faculty->faculty_name }}</p>
                        <p class="mb-0"><strong>Departemen:</strong> {{ $journal->department->name }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Authors Management -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users"></i> Daftar Author Jurnal
                </h5>
                <div>
                    @can('update', $journal)
                        <a href="{{ route('journal-authors.create', $journal) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Author
                        </a>
                    @endcan
                    <a href="{{ route('journals.show', $journal) }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali ke Jurnal
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($authors->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Urutan</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>Institusi</th>
                                    <th>Corresponding</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($authors as $author)
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary">{{ $author->order }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $author->full_name }}</strong>
                                        </td>
                                        <td>
                                            <a href="mailto:{{ $author->email }}" class="text-decoration-none">
                                                <i class="fas fa-envelope"></i> {{ $author->email }}
                                            </a>
                                        </td>
                                        <td>{{ $author->institution }}</td>
                                        <td>
                                            @if($author->is_corresponding)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check"></i> Ya
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">Tidak</span>
                                            @endif
                                        </td>
                                        <td>
                                            @can('update', $journal)
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('journal-authors.edit', [$journal, $author]) }}"
                                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('journal-authors.destroy', [$journal, $author]) }}"
                                                          class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                onclick="return confirm('Yakin ingin menghapus author ini?')"
                                                                title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-user-friends fa-3x mb-3"></i>
                        <p>Belum ada author yang ditambahkan untuk jurnal ini.</p>
                        @can('update', $journal)
                            <a href="{{ route('journal-authors.create', $journal) }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Author Pertama
                            </a>
                        @endcan
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
