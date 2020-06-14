<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        $rules = [
            'client_id' => 'required|numeric|exists:clients,id',
            'payment_form_id' => 'sometimes',
            'description' => 'sometimes',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric',
            'products.*.value' => 'required',
            'products.*.observation' => 'sometimes',

        ];

        return $rules;
    }
}
