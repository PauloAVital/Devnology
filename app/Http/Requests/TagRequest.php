<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
            'id_user' => 'required', 
            'nome_github' => 'required',
            'language_github' => 'required',
            'link_github' => 'required'
        ];
    }

    public function messages() {
        return [
            'id_user.required' => 'Você deve escolher um usuário',
            'nome_github.required' => 'Você deve preencher um repositório',
            'language_github.required' => 'Você deve preencher uma linguagem',
            'link_github.required' => 'Você deve preencher o link',
        ];
    }
}
