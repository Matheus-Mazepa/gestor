<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'sometimes|max:255',
            'phone' => 'required|max:15',
            'is_legal_person' => 'required|in:cnpj,cpf',
            'cpf_cnpj'=> 'required',
            'ie_estadual' => 'sometimes',
            'ie_municipal' => 'sometimes',

            'address.number' => 'required',
            'address.cep' => 'required|string',
            'address.state' => 'required|exists:states,abbr',
            'address.street_avenue' => 'required|string',
            'address.district' => 'required|string',
            'address.city_id' => 'required|exists:cities,id',
            'address.complement' => 'sometimes'

        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $rules['email'] .= ",{$this->client}";
        }

        return $rules;
    }
}
