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
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'where_found' => ['nullable', 'array'],
            'where_found.*' => ['in:google,facebook,other'],
            'subject' => ['required', 'string', 'max:200'],
            'message' => ['required', 'string', 'min:20', 'max:2000'],
            'website' => ['nullable', 'string', 'max:1'],
            'captcha_answer' => ['required', function ($attr, $value, $fail) {
                if (trim($value) !== '5') {
                    $fail('Güvenlik sorusu yanlış.');
                }
            }],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Ad Soyad zorunludur.',
            'email.required' => 'E-posta zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'subject.required' => 'Konu zorunludur.',
            'message.required' => 'Mesaj zorunludur.',
            'message.min' => 'Mesaj en az 20 karakter olmalıdır.',
            'message.max' => 'Mesaj en fazla 2000 karakter olabilir.',
            'captcha_answer.required' => 'Güvenlik sorusunu cevaplayınız.',
            'captcha_answer.in' => 'Güvenlik sorusu yanlış.',
        ];
    }
}
