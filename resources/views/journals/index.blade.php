@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Daftar Jurnal</h1>
    @can('create', App\Models\Journal::class)
        <a href="{{ route('journals.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Jurnal
        </a>
    @endcan
</div>

<!-- Filter Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('journals.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari jurnal..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Submitted</option>
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
                        <a href="{{ route('journals.show', $journal) }}" class="text-decoration-none">
                            {{ $journal->journal_name }}
                        </a>
                    </h5>
                    <p class="card-text">
                        {{ Str::limit($journal->abstract, 150) }}
                    </p>
                    <div class="mb-2">
                        <small class="text-muted">
                            <i class="fas fa-user"></i> {{ $journal->coAuthors->count() > 0 ?  $journal->coAuthors[0]->last_name . ' , ' .$journal->coAuthors[0]->first_name : '' }}<br>
                            <i class="fas fa-building"></i> {{ $journal->faculty ? $journal->faculty->faculty_name : ''}}<br>
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
                            @can('update', $journal)
                                <a href="{{ route('journals.edit', $journal) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan
                            @can('delete', $journal)
                                <form method="POST" action="{{ route('journals.destroy', $journal) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Yakin ingin menghapus jurnal ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endcan
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

@push('scripts')
<script>

class KeywordExtractor {
    constructor() {
        // Stopwords bahasa Indonesia
        this.stopwordsID = new Set([
            'dan', 'atau', 'dengan', 'pada', 'dalam', 'untuk', 'dari', 'ke', 'di', 'oleh',
            'sebagai', 'adalah', 'akan', 'dapat', 'telah', 'sudah', 'belum', 'tidak',
            'bukan', 'juga', 'saja', 'hanya', 'ini', 'itu', 'yang', 'tersebut',
            'sebuah', 'suatu', 'satu', 'dua', 'tiga', 'empat', 'lima',
            'tentang', 'antara', 'selama', 'setelah', 'sebelum', 'hingga',
            'karena', 'sehingga', 'bahwa', 'jika', 'apabila', 'ketika',
            'dimana', 'bagaimana', 'mengapa', 'siapa', 'kapan', 'apa',
            'ada', 'adanya', 'terdapat', 'memiliki', 'mempunyai',
            'seperti', 'sama', 'berbeda', 'lebih', 'kurang', 'paling',
            'sangat', 'cukup', 'agak', 'hampir', 'sekitar'
        ]);

        // Stopwords bahasa Inggris
        this.stopwordsEN = new Set([
            'the', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with',
            'by', 'as', 'is', 'are', 'was', 'were', 'be', 'been', 'being',
            'have', 'has', 'had', 'do', 'does', 'did', 'will', 'would', 'could',
            'should', 'may', 'might', 'must', 'can', 'cannot', 'not', 'no',
            'this', 'that', 'these', 'those', 'a', 'an', 'one', 'two', 'three',
            'first', 'second', 'third', 'about', 'above', 'after', 'before',
            'during', 'through', 'between', 'among', 'because', 'since',
            'if', 'when', 'where', 'how', 'why', 'what', 'who', 'which',
            'there', 'here', 'then', 'than', 'so', 'very', 'much', 'many',
            'most', 'more', 'less', 'some', 'any', 'all', 'each', 'every',
            'other', 'another', 'same', 'different', 'new', 'old', 'good',
            'bad', 'big', 'small', 'long', 'short', 'high', 'low'
        ]);

        // Kata-kata umum dalam jurnal yang biasanya bukan keyword
        this.academicStopwords = new Set([
            'penelitian', 'study', 'research', 'analysis', 'analisis',
            'hasil', 'result', 'conclusion', 'kesimpulan', 'method', 'metode',
            'approach', 'pendekatan', 'paper', 'artikel', 'journal', 'jurnal',
            'abstract', 'abstrak', 'introduction', 'pendahuluan',
            'discussion', 'pembahasan', 'literature', 'literatur',
            'reference', 'referensi', 'bibliography', 'daftar'
        ]);
    }

    // Deteksi bahasa sederhana berdasarkan kata-kata umum
    detectLanguage(text) {
        const indonesianWords = ['dan', 'atau', 'dengan', 'dalam', 'untuk', 'dari', 'pada', 'yang', 'adalah', 'akan'];
        const englishWords = ['and', 'or', 'with', 'in', 'for', 'from', 'on', 'the', 'is', 'will'];

        const words = text.toLowerCase().split(/\s+/);
        let idScore = 0;
        let enScore = 0;

        words.forEach(word => {
            if (indonesianWords.includes(word)) idScore++;
            if (englishWords.includes(word)) enScore++;
        });

        return idScore > enScore ? 'id' : 'en';
    }

    // Preprocessing teks
    preprocessText(text) {
        return text
            .toLowerCase()
            .replace(/[^\w\s]/g, ' ') // Hapus tanda baca
            .replace(/\d+/g, '') // Hapus angka
            .replace(/\s+/g, ' ') // Normalize whitespace
            .trim();
    }

    // Stemming sederhana untuk bahasa Indonesia
    stemIndonesian(word) {
        // Hapus prefix umum
        word = word.replace(/^(me|ber|ter|di|ke|se|pe)/, '');

        // Hapus suffix umum
        word = word.replace(/(kan|an|i|nya|lah|kah)$/, '');

        return word.length >= 3 ? word : word;
    }

    // Stemming sederhana untuk bahasa Inggris
    stemEnglish(word) {
        // Hapus suffix umum
        if (word.endsWith('ing')) word = word.slice(0, -3);
        else if (word.endsWith('ed')) word = word.slice(0, -2);
        else if (word.endsWith('er')) word = word.slice(0, -2);
        else if (word.endsWith('ly')) word = word.slice(0, -2);
        else if (word.endsWith('tion')) word = word.slice(0, -4);
        else if (word.endsWith('ness')) word = word.slice(0, -4);
        else if (word.endsWith('ment')) word = word.slice(0, -4);
        else if (word.endsWith('able')) word = word.slice(0, -4);
        else if (word.endsWith('ible')) word = word.slice(0, -4);
        else if (word.endsWith('s') && word.length > 3) word = word.slice(0, -1);

        return word.length >= 3 ? word : word;
    }

    // Ekstrak keyword dari teks
    extractKeywords(text, maxKeywords = 10, minLength = 3) {
        // Deteksi bahasa
        const language = this.detectLanguage(text);
        const stopwords = language === 'id' ? this.stopwordsID : this.stopwordsEN;

        // Preprocessing
        const processedText = this.preprocessText(text);
        const words = processedText.split(/\s+/).filter(word => word.length >= minLength);

        // Hitung frekuensi kata dengan stemming
        const wordFreq = new Map();
        const stemToOriginal = new Map();

        words.forEach(word => {
            // Skip stopwords dan academic stopwords
            if (stopwords.has(word) || this.academicStopwords.has(word)) {
                return;
            }

            // Stemming
            const stemmed = language === 'id' ?
                this.stemIndonesian(word) :
                this.stemEnglish(word);

            // Skip jika stem terlalu pendek
            if (stemmed.length < minLength) return;

            // Update frekuensi
            wordFreq.set(stemmed, (wordFreq.get(stemmed) || 0) + 1);

            // Simpan mapping stem ke kata asli (yang lebih panjang)
            if (!stemToOriginal.has(stemmed) || word.length > stemToOriginal.get(stemmed).length) {
                stemToOriginal.set(stemmed, word);
            }
        });

        // Buat n-gram (bigram dan trigram)
        const ngrams = this.extractNGrams(words, stopwords, language, 2, 3);

        // Gabungkan single words dan n-grams
        const allTerms = new Map();

        // Tambahkan single words
        wordFreq.forEach((freq, stem) => {
            const originalWord = stemToOriginal.get(stem);
            allTerms.set(originalWord, {
                frequency: freq,
                type: 'word',
                score: freq
            });
        });

        // Tambahkan n-grams
        ngrams.forEach((freq, ngram) => {
            allTerms.set(ngram, {
                frequency: freq,
                type: 'ngram',
                score: freq * 1.5 // Beri bobot lebih untuk n-gram
            });
        });

        // Sort berdasarkan score dan ambil top keywords
        const sortedTerms = Array.from(allTerms.entries())
            .sort((a, b) => b[1].score - a[1].score)
            .slice(0, maxKeywords);

        return {
            language: language,
            keywords: sortedTerms.map(([term, data]) => ({
                keyword: term,
                frequency: data.frequency,
                type: data.type,
                score: data.score
            }))
        };
    }

    // Ekstrak n-gram (phrase dengan n kata)
    extractNGrams(words, stopwords, language, ...nValues) {
        const ngrams = new Map();

        nValues.forEach(n => {
            for (let i = 0; i <= words.length - n; i++) {
                const ngram = words.slice(i, i + n);

                // Skip jika mengandung stopword
                const hasStopword = ngram.some(word =>
                    stopwords.has(word) || this.academicStopwords.has(word)
                );

                if (!hasStopword && ngram.every(word => word.length >= 3)) {
                    const phrase = ngram.join(' ');
                    ngrams.set(phrase, (ngrams.get(phrase) || 0) + 1);
                }
            }
        });

        // Filter n-gram dengan frekuensi minimal 2
        const filteredNgrams = new Map();
        ngrams.forEach((freq, ngram) => {
            if (freq >= 2) {
                filteredNgrams.set(ngram, freq);
            }
        });

        return filteredNgrams;
    }

    // Analisis keyword density
    analyzeKeywordDensity(text, keywords) {
        const totalWords = this.preprocessText(text).split(/\s+/).length;

        return keywords.map(kw => ({
            ...kw,
            density: ((kw.frequency / totalWords) * 100).toFixed(2) + '%'
        }));
    }
}

// Fungsi utama untuk mengekstrak keyword
function extractKeywordsFromAbstract(abstractText, options = {}) {
    const {
        maxKeywords = 10,
        minLength = 3,
        includeDensity = true
    } = options;

    const extractor = new KeywordExtractor();
    const result = extractor.extractKeywords(abstractText, maxKeywords, minLength);

    if (includeDensity) {
        result.keywords = extractor.analyzeKeywordDensity(abstractText, result.keywords);
    }

    return result;
}
</script>
@endpush

<!-- Pagination -->
{{ $journals->links() }}
@endsection
