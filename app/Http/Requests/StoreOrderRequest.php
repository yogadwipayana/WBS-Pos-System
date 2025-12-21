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
        return true; // Allow all customers to create orders
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'order_number' => 'required|string|max:255|unique:orders,order_number',
            'customer_name' => 'required|string|min:2|max:255',
            'order_type' => 'required|in:dinein,takeaway',
            'table_number' => 'nullable|string|max:50',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1|max:100'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'order_number.required' => 'Order number is required',
            'order_number.unique' => 'This order number already exists',
            'customer_name.required' => 'Customer name is required',
            'customer_name.min' => 'Customer name must be at least 2 characters',
            'order_type.required' => 'Order type is required',
            'order_type.in' => 'Order type must be either dine-in or takeaway',
            'items.required' => 'At least one item is required',
            'items.min' => 'At least one item is required',
            'items.*.product_name.required' => 'Product name is required for all items',
            'items.*.quantity.required' => 'Quantity is required for all items',
            'items.*.quantity.min' => 'Quantity must be at least 1',
            'items.*.quantity.max' => 'Quantity cannot exceed 100',
        ];
    }
}
