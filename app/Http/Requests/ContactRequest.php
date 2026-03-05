<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:6',
                'max:60',
                'regex:/^[\p{L}]{3,}\s+[\p{L}]{3,}$/u',
            ],
            'email' => ['required', 'email:rfc', 'max:120'],
            'message' => ['required', 'string', 'min:20', 'max:2000'],
            'website' => ['nullable', 'string', 'max:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Lütfen ad ve soyad giriniz.',
            'name.min' => 'Ad ve soyad en az 6 karakter olmalıdır.',
            'name.max' => 'Ad ve soyad en fazla 60 karakter olabilir.',
            'name.regex' => 'Lütfen geçerli ad ve soyad giriniz (en az iki kelime, her biri en az 3 harf, sadece harf).',
            'email.required' => 'Lütfen e-posta adresinizi giriniz.',
            'email.email' => 'Lütfen geçerli bir e-posta adresi giriniz.',
            'email.max' => 'E-posta adresi en fazla 120 karakter olabilir.',
            'message.required' => 'Lütfen mesajınızı giriniz.',
            'message.min' => 'Mesaj en az 20 karakter olmalıdır.',
            'message.max' => 'Mesaj en fazla 2000 karakter olabilir.',
        ];
    }
}
