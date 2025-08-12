<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JournalAuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'institution' => 'required|string|max:255',
            'order' => 'required|integer|min:1',
            'is_corresponding' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Nama depan wajib diisi.',
            'last_name.required' => 'Nama belakang wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'institution.required' => 'Institusi wajib diisi.',
            'order.required' => 'Urutan author wajib diisi.',
            'order.min' => 'Urutan author minimal 1.',
        ];
    }
}
