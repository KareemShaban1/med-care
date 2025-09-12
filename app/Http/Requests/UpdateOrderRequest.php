<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
            'delivery_address' => 'required|string',
            'total' => 'required|numeric',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:order_items,id',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer',
        ];
    }
}
