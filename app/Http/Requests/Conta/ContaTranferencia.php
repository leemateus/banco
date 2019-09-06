<?php

namespace App\Http\Requests\Conta;

use Illuminate\Foundation\Http\FormRequest;

class ContaTranferencia extends FormRequest
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
            'valor' => 'required|decimal',
            'idContaCredita' => 'required|integer'
        ];
    }
}
