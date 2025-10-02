<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JournalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return auth()->check() && (auth()->user()->isEditor() || auth()->user()->isAdmin());
    }

    public function rules()
    {
        $journalId = $this->route('journal') ? $this->route('journal')->id : null;

        return [
            'journal_name' => 'required|string|max:255',
            'abstract' => 'required|string|min:100',
            'keyword' => 'required|string|max:500',
            'category_id' => 'required|exists:journal_categories,id',
            'doi' => 'nullable|string|max:100|unique:journals,doi,' . $journalId,
            'issn' => 'nullable|string|max:20',
            'institution_code' => 'required|exists:institutions,institution_code',
            'faculty_code' => 'required|exists:faculties,faculty_code',
            'department_code' => 'required|exists:departments,department_code',
            'revision_number' => 'required|integer|min:0',
            'page_start' => 'nullable|integer|min:1',
            'page_end' => 'nullable|integer|min:1|gte:page_start',
            'publication_date' => 'nullable|date',
            'publisher' => 'nullable|string|max:255',
            'institution' => 'required|string|max:255',
            'language' => 'required|in:id,en,es,fr,de,ja,ko,pt,ru,zh',
            'status' => 'required|in:draft,submitted,under_review,accepted,published,rejected',
            'pdf_file' => $this->isMethod('POST') ? 'required|file|mimes:pdf|max:10240' : 'nullable|file|mimes:pdf|max:10240',
            'other_document_file' => 'nullable|file|max:10240',
        ];
    }

    public function messages()
    {
        return [
            'journal_name.required' => 'Nama jurnal wajib diisi.',
            'abstract.required' => 'Abstrak wajib diisi.',
            'abstract.min' => 'Abstrak minimal 100 karakter.',
            'keyword.required' => 'Kata kunci wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'pdf_file.required' => 'File PDF wajib diupload.',
            'pdf_file.mimes' => 'File harus berformat PDF.',
            'pdf_file.max' => 'Ukuran file PDF maksimal 10MB.',
            'page_end.gte' => 'Halaman akhir harus lebih besar atau sama dengan halaman awal.',
        ];
    }
}
