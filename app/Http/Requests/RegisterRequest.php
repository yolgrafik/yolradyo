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
            'name.required' => 'Ad ve soyad alanı zorunludur.',
            'name.regex' => 'Ad ve soyad iki kelimeden oluşmalı; her kelime en az 3 karakter ve yalnızca harf içermelidir.',
            'name.max' => 'Ad ve soyad en fazla 60 karakter olabilir.',
            'email.required' => 'E-posta adresi zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.unique' => 'Bu e-posta adresi sistemimizde kayıtlıdır.',
            'password.required' => 'Şifre alanı zorunludur.',
            'password.min' => 'Şifre en az 8 karakter olmalıdır.',
            'password.confirmed' => 'Şifre tekrarı eşleşmiyor. Lütfen kontrol ediniz.',
            'terms_accepted.required' => 'Kullanım şartlarını kabul etmeniz gerekmektedir.',
            'terms_accepted.accepted' => 'Devam etmek için kullanım şartlarını kabul etmelisiniz.',
            'privacy_accepted.required' => 'Gizlilik politikası ve KVKK metnini kabul etmeniz gerekmektedir.',
            'privacy_accepted.accepted' => 'Devam etmek için gizlilik politikası ve KVKK metnini kabul etmelisiniz.',
        ];
    }
}
