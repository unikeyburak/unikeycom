<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'current_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:8|confirmed',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'current_password.required' => 'Mevcut şifre zorunludur',
            'current_password.min' => 'Mevcut şifre en az 6 karakter olmalıdır',
            'new_password.required' => 'Yeni şifre zorunludur',
            'new_password.min' => 'Yeni şifre en az 8 karakter olmalıdır',
            'new_password.confirmed' => 'Şifre tekrarı eşleşmiyor',
        ];
    }
}