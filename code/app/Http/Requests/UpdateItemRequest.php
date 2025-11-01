<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // For now, just check if user is authenticated
        // TODO: Add proper permission checks when roles are implemented
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:2',
            ],
            'sku' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('items', 'sku')->ignore($this->route('item')),
                'regex:/^[A-Za-z0-9\-_]+$/',
            ],
            'type' => [
                'required',
                'in:INSUMO,PRODUCTO,ACTIVO',
            ],
            'default_uom_id' => [
                'required',
                'uuid',
                'exists:uoms,id',
            ],
            'selling_price' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999999.99',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'is_stocked' => [
                'boolean',
            ],
            'is_perishable' => [
                'boolean',
            ],
            'has_variants' => [
                'boolean',
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => __('app.name'),
            'sku' => __('items.sku'),
            'type' => __('app.type'),
            'default_uom_id' => __('items.default_uom'),
            'selling_price' => __('items.selling_price'),
            'notes' => __('app.description'),
            'is_stocked' => __('items.is_stocked'),
            'is_perishable' => __('items.is_perishable'),
            'has_variants' => __('items.has_variants'),
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('app.name')]),
            'name.min' => __('validation.min.string', ['attribute' => __('app.name'), 'min' => 2]),
            'name.max' => __('validation.max.string', ['attribute' => __('app.name'), 'max' => 255]),
            'sku.unique' => __('items.sku_unique'),
            'sku.regex' => __('items.sku_format'),
            'type.required' => __('validation.required', ['attribute' => __('app.type')]),
            'type.in' => __('items.invalid_type'),
            'default_uom_id.required' => __('items.default_uom_required'),
            'default_uom_id.exists' => __('items.invalid_uom'),
            'selling_price.min' => __('items.positive_number'),
            'selling_price.max' => __('items.price_too_high'),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert empty strings to null for nullable fields
        if ($this->sku === '') {
            $this->merge(['sku' => null]);
        }
        
        if ($this->selling_price === '') {
            $this->merge(['selling_price' => null]);
        }
        
        if ($this->notes === '') {
            $this->merge(['notes' => null]);
        }

        // Ensure boolean fields are properly cast
        $this->merge([
            'is_stocked' => $this->boolean('is_stocked'),
            'is_perishable' => $this->boolean('is_perishable'),
            'has_variants' => $this->boolean('has_variants'),
        ]);
    }
}
