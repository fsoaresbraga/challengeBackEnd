<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
           'name' => 'required',
           'email'=> ['required', 'email'],
           'birthday'=> 'required',
          

        ];
    }
    public function messages()
    {
        return [
           'name.required' => 'O campo nome é obrigatório',
           'email.required'=> 'O campo Email é obrigatório.',
           'email.email'=> 'O campo Email não é valido.',
           'birthday.required'=> 'O campo Aniversário é obrigatório',
        ];
    }
}
