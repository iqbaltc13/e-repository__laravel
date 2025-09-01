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
                    <div class="mb-3">
                         <a class="btn btn-info btn-create-keyword">
                             Buatkan Kata Kunci
                         </a>
                    </div>

                    <!-- Institution Information -->
                    <h6 class="mb-3 mt-4">Informasi Institusi</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="institution_code" class="form-label">Universitas <span class="text-danger">*</span></label>
                                <select class="form-select @error('institution_code') is-invalid @enderror"
                                        id="institution_code" name="institution_code" required>


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

    countWords(text) {
        return text.split(/\s+/).length;
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

$(document).delegate('.btn-create-keyword', 'click', function() {

    const extractor = new KeywordExtractor();
    const wordCount = extractor.countWords($('#abstract').val());
    if (wordCount < 100) {
        alert('Abstract harus minimal 100 kata');
        return;
    }
    const abstractText = $('#abstract').val();
    const result = extractKeywordsFromAbstract(abstractText);
    $('#keywords').val(result.keywords.map(kw => kw.keyword).join(', '));
});
</script>
<script>
   $(document).ready(function() {
            // Inisialisasi Select2 dengan tema Bootstrap
            function initializeSelect2(selector, placeholder) {
                $(selector).select2({
                    theme: 'bootstrap',
                    placeholder: placeholder,
                    allowClear: true,
                    language: 'id',
                    escapeMarkup: function(markup) {
                        return markup;
                    }
                });
            }

            // Inisialisasi semua select2
            initializeSelect2('#institution_code', 'Pilih Universitas...');
            initializeSelect2('#faculty_code', 'Pilih Fakultas...');
            initializeSelect2('#department_code', 'Pilih Program Studi...');

            // Fungsi untuk menampilkan loading
            function showLoading(selector) {
                $(selector).prop('disabled', true);
                $(selector).html('<option value="">Memuat...</option>');
            }

            // Fungsi untuk reset select
            function resetSelect(selector, placeholder) {
                $(selector).prop('disabled', true);
                $(selector).html(`<option value="">${placeholder}</option>`);
                $(selector).val('').trigger('change');
            }

            async function loadUniversitas() {
            try {
                showLoading('#institution_code');

                const response = await $.ajax({
                    url: "{{ route('get-universitas') }}", // Endpoint API Anda
                    method: 'GET',
                    dataType: 'json'
                });

                let options = '<option value="">-- Pilih Universitas --</option>';
                response.data.forEach(univ => {
                    options += `<option value="${univ.institution_code}">${univ.institution_name}</option>`;
                });

                $('#institution_code').html(options).prop('disabled', false);

            } catch (error) {
                console.error('Error loading universitas:', error);
                $('#institution_code').html('<option value="">Error memuat data</option>');
            }
        }

        async function loadFakultas(universitasCode) {
            if (!universitasCode) {
                resetSelect('#faculty_code', '-- Pilih Fakultas --');
                resetSelect('#department_code', '-- Pilih Program Studi --');
                return;
            }

            try {
                showLoading('#faculty_code');
                resetSelect('#department_code', '-- Pilih Program Studi --');

                const response = await $.ajax({
                    url: "{{ route('get-fakultas') }}",
                    method: 'GET',
                    data: { institution_code: universitasCode },
                    dataType: 'json'
                });

                let options = '<option value="">-- Pilih Fakultas --</option>';
                response.data.forEach(fakultas => {
                    options += `<option value="${fakultas.faculty_code}">${fakultas.faculty_name}</option>`;
                });

                $('#faculty_code').html(options).prop('disabled', false);

            } catch (error) {
                console.error('Error loading fakultas:', error);
                $('#faculty_code').html('<option value="">Error memuat data</option>');
            }
        }

        async function loadProdi(universitasCode, fakultasCode) {
            if (!universitasCode || !fakultasCode) {
                resetSelect('#department_code', '-- Pilih Program Studi --');
                return;
            }

            try {
                showLoading('#department_code');

                const response = await $.ajax({
                    url: "{{ route('get-prodi') }}",
                    method: 'GET',
                    data: {
                        institution_code: universitasCode,
                        faculty_code: fakultasCode
                    },
                    dataType: 'json'
                });

                let options = '<option value="">-- Pilih Program Studi --</option>';
                response.data.forEach(prodi => {
                    options += `<option value="${prodi.department_code}">${prodi.department_name}</option>`;
                });

                $('#department_code').html(options).prop('disabled', false);

            } catch (error) {
                console.error('Error loading prodi:', error);
                $('#department_code').html('<option value="">Error memuat data</option>');
            }
        }
         $('#institution_code').on('change', function() {
                const universitasCode = $(this).val();
                loadFakultas(universitasCode);
        });

        $('#faculty_code').on('change', function() {
            const universitasCode = $('#institution_code').val();
            const fakultasCode = $(this).val();
            loadProdi(universitasCode, fakultasCode);
        });

        loadUniversitas();
    });
</script>
@endpush
@endsection
