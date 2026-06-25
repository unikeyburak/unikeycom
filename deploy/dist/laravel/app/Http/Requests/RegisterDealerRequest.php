<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterDealerRequest extends FormRequest
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
            'company_name' => 'required|string|max:255',
            'tax_number' => 'required|string|max:50|unique:dealers,tax_number',
            'tax_office' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:100|unique:dealers,email',
            'website' => 'nullable|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'about' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'company_name.required' => 'Firma adı zorunludur',
            'tax_number.required' => 'Vergi numarası zorunludur',
            'tax_number.unique' => 'Bu vergi numarası ile kayıtlı bir bayi bulunmaktadır',
            'tax_office.required' => 'Vergi dairesi zorunludur',
            'phone.required' => 'Telefon numarası zorunludur',
            'email.required' => 'E-posta adresi zorunludur',
            'email.email' => 'Geçerli bir e-posta adresi giriniz',
            'email.unique' => 'Bu e-posta adresi ile kayıtlı bir bayi bulunmaktadır',
            'address.required' => 'Adres zorunludur',
            'city.required' => 'İl zorunludur',
            'district.required' => 'İlçe zorunludur',
        ];
    }
}