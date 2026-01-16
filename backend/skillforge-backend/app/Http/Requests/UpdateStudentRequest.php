<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
        $studentId = $this->route('student')->id ?? $this->route('student');
        
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:students,email,' . $studentId . '|max:255'
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
            'email.unique' => 'Ez az email cím már foglalt.',
            'email.max' => 'Az email cím maximum 255 karakter lehet.',
        ];
    }
}
