<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'old_price' => 'required|numeric',
            'stock' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'status' => 'boolean',
            'featured' => 'boolean',
            'type' => 'required|in:normal,best_seller,new_arrival,popular,top_rated',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }
}
