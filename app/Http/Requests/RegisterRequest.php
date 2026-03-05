<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
                'max:60',
                'regex:/^[\p{L}]{3,}\s+[\p{L}]{3,}$/u',
            ],
            'email' => ['required', 'email:rfc', 'max:120', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms_accepted' => ['required', 'accepted'],
            'privacy_accepted' => ['required', 'accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Lütfen ad ve soyad giriniz.',
            'name.regex' => 'Ad Soyad: 2 kelime, sadece harf, her kelime en az 3 karakter olmalıdır.',
            'name.max' => 'Ad ve soyad en fazla 60 karakter olabilir.',
            'email.required' => 'Lütfen e-posta adresinizi giriniz.',
            'email.email' => 'Lütfen geçerli bir e-posta adresi giriniz.',
            'email.unique' => 'Bu e-posta adresi zaten kayıtlı.',
            'password.required' => 'Lütfen şifre giriniz.',
            'password.min' => 'Şifre en az 8 karakter olmalıdır.',
            'password.confirmed' => 'Şifre tekrarı eşleşmiyor.',
            'terms_accepted.required' => 'Kullanım şartlarını kabul etmelisiniz.',
            'terms_accepted.accepted' => 'Kullanım şartlarını kabul etmelisiniz.',
            'privacy_accepted.required' => 'Gizlilik politikası ve KVKK metnini kabul etmelisiniz.',
            'privacy_accepted.accepted' => 'Gizlilik politikası ve KVKK metnini kabul etmelisiniz.',
        ];
    }
}
