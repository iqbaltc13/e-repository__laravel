@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Header -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-start">
                <div>
                    <h4 class="card-title mb-2">{{ $journal->journal_name }}</h4>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge bg-{{ $journal->status === 'published' ? 'success' : ($journal->status === 'rejected' ? 'danger' : 'warning') }} fs-6">
                            {{ ucfirst($journal->status) }}
                        </span>
                        <span class="badge bg-info">{{ strtoupper($journal->language) }}</span>
                        <small class="text-muted">
                            <i class="fas fa-eye"></i> {{ $journal->views_count }} views
                            <i class="fas fa-download ms-2"></i> {{ $journal->downloads_count }} downloads
                        </small>
                    </div>
                </div>
                <div class="btn-group">
                    @can('update', $journal)
                        <a href="{{ route('journals.edit', $journal) }}" class="btn btn-primary" style="height: 86px;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    @endcan
                    @can('publish', $journal)
                        @if($journal->status !== 'published')
                            <form method="POST" action="{{ route('journals.publish', $journal) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success" style="height: 86px;"
                                        onclick="return confirm('Yakin ingin mempublish jurnal ini?')">
                                    <i class="fas fa-globe"></i> Publish
                                </button>
                            </form>
                        @endif
                    @endcan
                    <a href="{{ route('journals.download', $journal) }}" class="btn btn-outline-primary"    style="height: 86px;">
                        <i class="fas fa-download"></i> Download PDF
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-md-8">
                <!-- Abstract -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Abstrak</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-justify">{{ Str::replace(["\r", "\n"], '<br>', $journal->abstract) }}</p>
                    </div>
                </div>
                @if($journal->coAuthors->count() > 0)
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">Sitasi</h6>
                        <button id="copyCitationBtn"
                                class="btn btn-sm btn-outline-primary copy-btn"
                                type="button"
                                data-toggle="tooltip"
                                data-placement="left"
                                title="Salin ke clipboard"
                                aria-label="Salin sitasi ke clipboard">
                            <i class="far fa-copy"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <p id="apaCitation" class="text-justify">{{ $journal->coAuthors[0]->last_name . ' , ' .$journal->coAuthors[0]->first_name }}
                            @if ($journal->coAuthors->count() > 1) ,&amp;
                                {{$journal->coAuthors[1]->last_name . ' , '.$journal->coAuthors[1]->first_name}}.
                            @else
                                .
                            @endif
                            &nbsp; ({{$journal->publication_date->format('Y') }}). {{$journal->journal_name}}. <i>IAIN Kediri</i>
                            @if($journal->volume),{{$journal->volume}}@endif @if($journal->issue)({{$journal->issue}})@endif
                            @if($journal->pages_start && $journal->page_end){{$journal->pages_start}}-{{$journal->page_end}}@endif
                            @if($journal->doi).{{$journal->doi}}@endif


                        </p>
                    </div>
                </div>
                @endif
                <!-- Keywords -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Kata Kunci</h6>
                    </div>
                    <div class="card-body">
                        @foreach(explode(',', $journal->keywords) as $keyword)
                            <span class="badge bg-secondary me-1 mb-1">{{ trim($keyword) }}</span>
                        @endforeach
                    </div>
                </div>

                <!-- Authors -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">Daftar Author</h6>
                        @can('update', $journal)
                            <a href="{{ route('journal-authors.index', $journal) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-users"></i> Kelola Author
                            </a>
                        @endcan
                    </div>
                    <div class="card-body">
                        @if($journal->coAuthors->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($journal->coAuthors as $author)
                                    <div class="list-group-item px-0">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">
                                                    {{ $author->full_name }}
                                                    @if($author->is_corresponding)
                                                        <span class="badge bg-success ms-1">Corresponding</span>
                                                    @endif
                                                </h6>
                                                <p class="mb-1"><strong>{{ $author->institution }}</strong></p>
                                                <small class="text-muted">{{ $author->email }}</small>
                                            </div>
                                            <span class="badge bg-primary">{{ $author->order }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">Belum ada author yang ditambahkan.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <!-- Journal Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Informasi Jurnal</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td><strong>Author Utama:</strong></td>
                                <td>@if($journal->coAuthors->count() > 0){{ $journal->coAuthors[0]->first_name }} {{ $journal->coAuthors[0]->last_name }}@endif</td>
                            </tr>
                            <tr>
                                <td><strong>Kategori:</strong></td>
                                <td>
                                    @if(!is_null($journal->category))
                                    <a href="{{ route('journal-categories.show', $journal->category) }}"
                                       class="text-decoration-none">
                                        {{ $journal->category->name }}
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Universitas:</strong></td>
                                @if(!is_null($journal->universitas))
                                <td>{{ $journal->universitas->institution_name }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td><strong>Fakultas:</strong></td>
                                @if(!is_null($journal->faculty))
                                <td>{{ $journal->faculty->faculty_name }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td><strong>Departemen/Prodi:</strong></td>
                                @if(!is_null($journal->department))
                                <td>{{ $journal->department->department_name }}</td>
                                @endif
                            </tr>
                            @if($journal->doi)
                                <tr>
                                    <td><strong>DOI:</strong></td>
                                    <td><code>{{ $journal->doi }}</code></td>
                                </tr>
                            @endif
                            @if($journal->issn)
                                <tr>
                                    <td><strong>ISSN:</strong></td>
                                    <td><code>{{ $journal->issn }}</code></td>
                                </tr>
                            @endif
                            @if($journal->publisher)
                                <tr>
                                    <td><strong>Penerbit:</strong></td>
                                    <td>{{ $journal->publisher }}</td>
                                </tr>
                            @endif
                            @if($journal->pages_start && $journal->pages_end)
                                <tr>
                                    <td><strong>Halaman:</strong></td>
                                    <td>{{ $journal->pages_start }}-{{ $journal->pages_end }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td><strong>Revisi ke:</strong></td>
                                <td>{{ $journal->revision_number }}</td>
                            </tr>
                            @if($journal->publication_date)
                                <tr>
                                    <td><strong>Tanggal Publikasi:</strong></td>
                                    <td>{{ $journal->publication_date->format('d M Y') }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td><strong>Dibuat:</strong></td>
                                <td>{{ $journal->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Diupdate:</strong></td>
                                <td>{{ $journal->updated_at->format('d M Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Files -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">File</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('journals.download', $journal) }}" class="btn btn-primary">
                                <i class="fas fa-file-pdf"></i> Download PDF Jurnal
                            </a>
                            @if($journal->other_document_file)
                                @foreach ($filesPendukung as $file)
                                <a href="{{ $file }}"
                                   class="btn btn-outline-secondary" target="_blank">
                                    <i class="fas fa-file"></i> Dokumen Pendukung {{$loop->iteration }}
                                </a>
                                @endforeach

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });

  // Util: salin teks ke clipboard (pakai navigator.clipboard, fallback ke execCommand)
  function copyTextToClipboard(text) {
    if (navigator.clipboard && window.isSecureContext) {
      return navigator.clipboard.writeText(text);
    } else {
      // Fallback
      const textarea = document.createElement('textarea');
      textarea.value = text;
      textarea.style.position = 'fixed';
      textarea.style.top = '-1000px';
      textarea.style.left = '-1000px';
      document.body.appendChild(textarea);
      textarea.focus();
      textarea.select();
      try { document.execCommand('copy'); }
      finally { document.body.removeChild(textarea); }
      return Promise.resolve();
    }
  }

  // Handler tombol copy
  (function () {
    var btn = document.getElementById('copyCitationBtn');
    var citationEl = document.getElementById('apaCitation');

    btn.addEventListener('click', function () {
      var text = citationEl.innerText.trim();
      copyTextToClipboard(text).then(function () {
        // Umpan balik tooltip
        $(btn).tooltip('hide')
              .attr('data-original-title', 'Tersalin!')
              .tooltip('show');

        // Kembalikan tooltip ke teks semula setelah 1.5 detik
        setTimeout(function () {
          $(btn).tooltip('hide')
                .attr('data-original-title', 'Salin ke clipboard');
        }, 1500);
      });
    });
  })();
</script>
@endpush


@endsection
