<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovementsRequest extends FormRequest
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
            'account_id'=> 'required',
            'movement_id'=> 'required',
            'value'=> 'required',
 
         ];
    }
    public function messages()
    {
        return [
           'account_id.required'=> 'O campo Usuário éobrigatório ',
           'movement_id.required'=> 'O campo Movimentação é obrigatório',
           'value.required'=> 'O campo Valor é obrigatório',

        ];
    }
}
