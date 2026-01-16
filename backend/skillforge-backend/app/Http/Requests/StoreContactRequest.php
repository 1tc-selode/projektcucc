<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10|max:1000'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'A név kötelező.',
            'name.string' => 'A név szöveges formátumú legyen.',
            'name.max' => 'A név maximum 255 karakter lehet.',
            'email.required' => 'Az email cím kötelező.',
            'email.email' => 'Érvényes email címet adjon meg.',
            'email.max' => 'Az email cím maximum 255 karakter lehet.',
            'message.required' => 'Az üzenet kötelező.',
            'message.string' => 'Az üzenet szöveges formátumú legyen.',
            'message.min' => 'Az üzenet minimum 10 karakter legyen.',
            'message.max' => 'Az üzenet maximum 1000 karakter lehet.',
        ];
    }
}


