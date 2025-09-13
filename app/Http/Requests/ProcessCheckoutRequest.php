<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessCheckoutRequest extends FormRequest
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
            'customer_name' => 'required|string|min:5|max:255',
            'customer_phone' => 'required|string|min:11|max:15',
            'delivery_address' => 'required|string|min:10|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'customer_name.required' => __('Customer name is required'),
            'customer_name.min' => __('Customer name must be at least 5 characters'),
            'customer_name.max' => __('Customer name must be at most 255 characters'),
            'customer_phone.required' => __('Customer phone is required'),
            'customer_phone.min' => __('Customer phone must be at least 11 characters'),
            'customer_phone.max' => __('Customer phone must be at most 15 characters'),
            'delivery_address.required' => __('Delivery address is required'),
            'delivery_address.min' => __('Delivery address must be at least 10 characters'),
            'delivery_address.max' => __('Delivery address must be at most 1000 characters'),
        ];
    }
}
