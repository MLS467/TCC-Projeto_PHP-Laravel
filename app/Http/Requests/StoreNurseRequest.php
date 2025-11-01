<?php

namespace App\Http\Requests;

use App\Models\Adm;
use Illuminate\Foundation\Http\FormRequest;

class StoreNurseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'active' => 'int',
            'age' => 'required|integer|min:18|max:100',
            'apartment' => 'nullable|string|max:10',
            'birth' => 'required|date',
            'block' => 'nullable|string|max:10',
            'city' => 'required|string|max:255',
            'coren' => 'required|digits_between:5,15',
            'cpf' => 'required|digits:11',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'email' => 'required|email',
            'id_administrator_fk' => 'required|int',
            'name' => 'required|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'password' => 'required|string|min:6|max:255',
            'phone' => 'required|string|regex:/^\d{10,15}$/',
            'place_of_birth' => 'required|string|max:255',
            'sex' => 'required|in:masculino,feminino',
            'specialty' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
        ];
    }


    public function messages()
    {
        return [
            'photo.image' => 'A foto deve ser uma imagem.',
            'photo.mimes' => 'A foto deve ser um arquivo do tipo: jpg, jpeg, png.',
            'photo.max' => 'A foto não pode ter mais de 4096 KB.',
            'active.in' => 'O campo ativo deve ser on',
            'age.integer' => 'O campo idade deve ser um número inteiro',
            'age.min' => 'O campo idade deve ser no mínimo 18',
            'age.max' => 'O campo idade deve ser no máximo 100',
            'apartment.max' => 'O campo apartamento deve ter no máximo 10 caracteres',
            'birth.before' => 'A data de nascimento deve ser anterior a data atual',
            'block.max' => 'O campo bloco deve ter no máximo 10 caracteres',
            'city.max' => 'O campo cidade deve ter no máximo 255 caracteres',
            'coren.digits_between' => 'O COREN deve ter entre 5 e 15 dígitos',
            'cpf.digits' => 'O CPF deve ter 11 dígitos',
            'cpf.unique' => 'Este CPF já está cadastrado',
            'email.email' => 'O email deve ser um email válido',
            'email.unique' => 'Este email já está cadastrado',
            'id_administrator_fk.exists' => 'O administrador informado não existe',
            'id_administrator_fk.require' => 'O administrador é obrigatório',
            'name.max' => 'O nome deve ter no máximo 255 caracteres',
            'neighborhood.max' => 'O bairro deve ter no máximo 255 caracteres',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres',
            'password.max' => 'A senha deve ter no máximo 255 caracteres',
            'phone.regex' => 'O telefone deve ter entre 10 e 15 dígitos',
            'place_of_birth.max' => 'O local de nascimento deve ter no máximo 255 caracteres',
        ];
    }

    function prepareForValidation()
    {
        $this->merge([
            'role' => 'nurse',
            'active' => $this->has('active')  ? 1 : 0,
            'age' => (int) floor((strtotime(now()) - strtotime($this->birth)) / (60 * 60 * 24 * 365.25)),
            'id_administrator_fk' => (int) Adm::where('user_id', $this->id_administrator_fk)->value('id')
        ]);
    }
}