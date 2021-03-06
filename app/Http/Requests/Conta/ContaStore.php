<?php

namespace App\Http\Requests\Conta;

use Illuminate\Foundation\Http\FormRequest;

class ContaStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'Required|string|max:255',
            'email' => 'Required|string'
        ];
    }
}
