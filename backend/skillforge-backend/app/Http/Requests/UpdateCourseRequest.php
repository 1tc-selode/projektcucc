<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'status' => 'sometimes|in:planned,active,completed',
            'difficulty' => 'sometimes|required|in:beginner,intermediate,advanced',
            'instructor_id' => 'sometimes|required|exists:instructors,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'A kurzus címe kötelező.',
            'title.string' => 'A kurzus címe szöveges formátumú legyen.',
            'title.max' => 'A kurzus címe maximum 255 karakter lehet.',
            'description.required' => 'A kurzus leírása kötelező.',
            'description.string' => 'A kurzus leírása szöveges formátumú legyen.',
            'status.in' => 'A státusz csak planned, active vagy completed lehet.',
            'difficulty.required' => 'A nehézségi szint kötelező.',
            'difficulty.in' => 'A nehézségi szint csak beginner, intermediate vagy advanced lehet.',
            'instructor_id.required' => 'Az oktató ID kötelező.',
            'instructor_id.exists' => 'A megadott oktató nem létezik.',
        ];
    }
}
