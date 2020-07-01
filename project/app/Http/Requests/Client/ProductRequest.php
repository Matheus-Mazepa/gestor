<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|max:255',
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'ncm' => 'required|numeric',
            'price_nfe' => 'required|max:255',
            'price_nfc' => 'required|max:255',
            'commercial_unit' => 'required|max:255',
            'taxable_unit' => 'required|max:255',
            'cfop_nfc' => 'required|max:4',
            'cfop_nfe' => 'required|max:4',
            'minimal_quantity' => 'required|max:255',
            'taxable_quantity' => 'required|numeric',
            'category_id' => 'required|numeric|exists:categories,id',
            'products' => 'sometimes',
            'bundle-product' => 'sometimes',
        ];
    }
}
