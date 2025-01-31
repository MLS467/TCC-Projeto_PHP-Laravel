<?php

namespace App\Http\Requests;

use App\Models\Adm;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNurseRequest extends FormRequest
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
    public function rules()
    {
        return [
            'id_administrator_fk' => 'nullable|integer',
            'active' => 'required|boolean',
            'coren' => 'nullable|string|max:20',
            'speciality' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'email_verified_at' => 'nullable|date',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|regex:/^\+?[0-9\s\-\(\)]+$/|max:20',
            'cpf' => 'required|string|size:11|unique:users,cpf',
            'sex' => 'required',
            'birth' => 'required|date',
            'photo' => 'nullable|url',
            'place_of_birth' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'block' => 'nullable|string|max:255',
            'apartment' => 'nullable|string|max:10',
            'role' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'flag' => 'nullable|boolean'
        ];
    }

    public function messages()
    {
        return [
            'id_administrator_fk.integer' => 'O ID do administrador deve ser um número inteiro.',
            'active.required' => 'O campo ativo é obrigatório.',
            'active.boolean' => 'O campo ativo deve ser verdadeiro ou falso.',
            'coren.string' => 'O COREN deve ser um texto válido.',
            'coren.max' => 'O COREN não pode ter mais de 20 caracteres.',
            'speciality.string' => 'A especialidade deve ser um texto válido.',
            'speciality.max' => 'A especialidade não pode ter mais de 255 caracteres.',
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser um texto válido.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser um endereço válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'email.max' => 'O e-mail não pode ter mais de 255 caracteres.',
            'email_verified_at.date' => 'A data de verificação do e-mail deve ser uma data válida.',
            'password.required' => 'A senha é obrigatória.',
            'password.string' => 'A senha deve ser um texto válido.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'phone.string' => 'O telefone deve ser um texto válido.',
            'phone.regex' => 'O telefone deve estar em um formato válido.',
            'phone.max' => 'O telefone não pode ter mais de 20 caracteres.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.string' => 'O CPF deve ser um texto válido.',
            'cpf.size' => 'O CPF deve ter exatamente 11 caracteres.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'sex.required' => 'O sexo é obrigatório.',
            'birth.required' => 'A data de nascimento é obrigatória.',
            'birth.date' => 'A data de nascimento deve ser uma data válida.',
            'photo.url' => 'A foto deve ser uma URL válida.',
            'place_of_birth.string' => 'O local de nascimento deve ser um texto válido.',
            'place_of_birth.max' => 'O local de nascimento não pode ter mais de 255 caracteres.',
            'city.string' => 'A cidade deve ser um texto válido.',
            'city.max' => 'A cidade não pode ter mais de 255 caracteres.',
            'neighborhood.string' => 'O bairro deve ser um texto válido.',
            'neighborhood.max' => 'O bairro não pode ter mais de 255 caracteres.',
            'street.string' => 'A rua deve ser um texto válido.',
            'street.max' => 'A rua não pode ter mais de 255 caracteres.',
            'block.string' => 'O bloco deve ser um texto válido.',
            'block.max' => 'O bloco não pode ter mais de 255 caracteres.',
            'apartment.string' => 'O apartamento deve ser um texto válido.',
            'apartment.max' => 'O apartamento não pode ter mais de 10 caracteres.',
            'role.required' => 'O cargo é obrigatório.',
            'role.string' => 'O cargo deve ser um texto válido.',
            'role.max' => 'O cargo não pode ter mais de 255 caracteres.',
            'age.required' => 'A idade é obrigatória.',
            'age.integer' => 'A idade deve ser um número inteiro.',
            'age.min' => 'A idade não pode ser negativa.',
            'flag.boolean' => 'O campo flag deve ser verdadeiro ou falso.'
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'role' => 'doctor',
            'active' => $this->has('active')  ? 1 : 0,
            'age' => (int) floor((strtotime(now()) - strtotime($this->birth)) / (60 * 60 * 24 * 365.25)),

            // id_administrator_fk recebe o id do usuário que está autenticado e manda o id do administrador
            'id_administrator_fk' => (int) Adm::where('user_id', $this->id_administrator_fk)->value('id')
        ]);
    }
}