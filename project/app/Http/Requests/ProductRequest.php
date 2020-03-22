<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\UserInfo;

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
            'price_nfe' => 'required|max:255',
            'ncm' => 'required|numeric|max:8',
            'price_nfc' => 'required|max:10',
            'commercial_unit' => 'required|max:255',
            'taxable_unit' => 'required|max:255',
            'cfop_nfc' => 'required|max:4',
            'cfop_nfe' => 'required|max:4',
            'quantity' => 'required|max:255',
            'minimal_quantity' => 'required|max:255',
            'taxable_quantity' => 'required|numeric',
        ];
    }
}
