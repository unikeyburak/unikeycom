<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'items.required' => 'En az bir ürün seçmelisiniz',
            'items.array' => 'Ürün listesi geçersiz',
            'items.min' => 'En az bir ürün seçmelisiniz',
            'items.*.product_id.required' => 'Ürün seçimi zorunludur',
            'items.*.product_id.exists' => 'Seçilen ürün bulunamadı',
            'items.*.quantity.required' => 'Miktar zorunludur',
            'items.*.quantity.integer' => 'Miktar sayı olmalıdır',
            'items.*.quantity.min' => 'Miktar en az 1 olmalıdır',
        ];
    }
}