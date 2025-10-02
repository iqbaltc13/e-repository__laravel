@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">Dashboard</h1>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $totalJournals }}</h4>
                        <p class="card-text">Total Jurnal</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-book fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $publishedJournals }}</h4>
                        <p class="card-text">Jurnal Published</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $underReviewJournals }}</h4>
                        <p class="card-text">Under Review</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="col-md-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{  $submittedJournals}}</h4>
                        <p class="card-text">Unpublished Submission</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-file fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Jurnal Terbaru</h5>
            </div>
            <div class="card-body">
                @forelse($recentJournals as $journal)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <div>
                            <h6 class="mb-1">
                                <a href="{{ route('journals.public.show', $journal) }}" class="text-decoration-none">
                                    {{ strip_tags(html_entity_decode(Str::limit($journal->journal_name, 50))) }}
                                </a>
                            </h6>
                            <small class="text-muted">
                                oleh {{ $journal->author->fullname }} • {{ $journal->created_at->diffForHumans() }}
                            </small>
                        </div>
                        <span class="badge bg-{{ $journal->status === 'published' ? 'success' : 'warning' }}">
                            {{ ucfirst($journal->status) }}
                        </span>
                    </div>
                @empty
                    <p class="text-muted">Belum ada jurnal terbaru.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Jurnal Terpopuler</h5>
            </div>
            <div class="card-body">
                @forelse($popularJournals as $journal)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <div>
                            <h6 class="mb-1">
                                <a href="{{ route('journals.show', $journal) }}" class="text-decoration-none">
                                    {{ Str::limit($journal->journal_name, 50) }}
                                </a>
                            </h6>
                            <small class="text-muted">
                                {{ $journal->views_count }} views • {{ $journal->downloads_count }} downloads
                            </small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Belum ada data jurnal populer.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
