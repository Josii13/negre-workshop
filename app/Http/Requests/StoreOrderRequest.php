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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'message' => 'nullable|string|max:1000',
            'order_channel' => 'nullable|in:app,whatsapp',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'product_id.required' => 'Le produit est requis.',
            'product_id.exists' => 'Le produit sélectionné n\'existe pas.',
            'customer_name.required' => 'Le nom est requis.',
            'customer_name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'customer_email.required' => 'L\'email est requis.',
            'customer_email.email' => 'L\'email doit être une adresse email valide.',
            'customer_email.max' => 'L\'email ne peut pas dépasser 255 caractères.',
            'customer_phone.required' => 'Le téléphone est requis.',
            'customer_phone.max' => 'Le téléphone ne peut pas dépasser 20 caractères.',
            'message.max' => 'Le message ne peut pas dépasser 1000 caractères.',
        ];
    }
}

