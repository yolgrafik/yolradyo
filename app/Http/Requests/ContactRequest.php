<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'min:20', 'max:2000'],
            'website' => ['nullable', 'string', 'max:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'message.required' => 'Lütfen mesajınızı giriniz.',
            'message.min' => 'Mesaj en az 20 karakter olmalıdır.',
            'message.max' => 'Mesaj en fazla 2000 karakter olabilir.',
        ];
    }
}
