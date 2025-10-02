@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Daftar Jurnal</h1>

</div>

<!-- Filter Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('journals.public') }}">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari jurnal..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>

                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>

                    </select>
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') === $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Journals List -->
<div class="row">
    @forelse($journals as $journal)
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="badge bg-{{ $journal->status === 'published' ? 'success' : ($journal->status === 'rejected' ? 'danger' : 'warning') }}">
                        {{ ucfirst($journal->status) }}
                    </span>
                    <small class="text-muted">{{ $journal->created_at->format('d M Y') }}</small>
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ route('journals.public.show', $journal) }}" class="text-decoration-none">
                            {{ $journal->journal_name }}
                        </a>
                    </h5>
                    <p class="card-text">
                        {{ Str::limit($journal->abstract, 150) }}
                    </p>
                    <div class="mb-2">
                        <small class="text-muted">
                            <i class="fas fa-user"></i> {{ $journal->coAuthors->count() > 0 ?  $journal->coAuthors[0]->last_name . ' , ' .$journal->coAuthors[0]->first_name : '' }}<br>
                            <i class="fas fa-building"></i> {{$journal->faculty?  $journal->faculty->faculty_name : '' }}<br>
                            @if($journal->category)
                                <i class="fas fa-tag"></i> {{ $journal->category->name }}
                            @endif
                        </small>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                <i class="fas fa-eye"></i> {{ $journal->views_count }} views
                                <i class="fas fa-download ms-2"></i> {{ $journal->downloads_count }} downloads
                            </small>
                        </div>
                        <div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Belum ada jurnal yang tersedia.
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
{{ $journals->links() }}
@endsection
