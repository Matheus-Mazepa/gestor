<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\UserInfo;

class UserClientRequest extends FormRequest
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
            'cpf' => 'required|cpf|max:14|unique:user_infos,cpf',
            'born_date' => 'required|date_format:d/m/Y|before_or_equal:' . format_date(now(), 'd/m/Y'),

            'address.cep' => 'required|regex:/\d{5}-\d{3}/',
            'address.district' => 'required|max:255',
            'address.street' => 'required|max:255',
            'address.complement' => 'nullable|max:255',
            'address.number' => 'required|max:50',
            'address.city_id' => 'required|integer|min:1|exists:cities,id',
            'address.state_id' => 'required|integer|min:1|exists:states,id',

            'gender' => 'required|max:1',
            'phone' => 'nullable|phone',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|string|min:8|max:12',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $rules['email'] .= ",{$this->client}";
            $rules['password'] = data_get($this, 'password', '') ? $rules['password'] : '';

            $hasCpf = UserInfo::where('cpf', $this->cpf)
            ->where('user_id', '!=', $this->client)->exists();

            $rules['cpf'] = ($hasCpf)
                ? $rules['cpf']
                : 'cpf|max:14';
        }

        return $rules;
    }
}
