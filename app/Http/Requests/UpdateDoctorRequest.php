<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorRequest extends FormRequest
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
            'active' => 'nullable|integer',
            'role' => 'nullable|string|in:doctor,nurse,attendant',
            'name' => 'nullable|string|min:3|max:100',
            'age' => 'nullable|integer|min:18|max:100',
            'email' => 'nullable|email|max:150',
            'phone' => 'nullable|regex:/^\d{10,11}$/',
            'cpf' => 'nullable|string',
            'sex' => 'nullable|string|in:masculino,feminino',
            'birth' => 'nullable|date|before:today',
            'place_of_birth' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'neighborhood' => 'nullable|string|max:100',
            'street' => 'nullable|string|max:150',
            'block' => 'nullable|string|max:10',
            'apartment' => 'nullable|string|max:10',
            'crm' => 'nullable|string|regex:/^CRM\d+$/',
            'specialty' => 'nullable|string|max:100',

        ];
    }

    public function messages(): array
    {
        return [
            'active.boolean' => 'O campo "ativo" deve ser um inteiro.',
            'role.in' => 'O campo "role" deve ser um dos seguintes valores: doctor, nurse ou attendant.',
            'name.min' => 'O campo "nome" deve ter pelo menos 3 caracteres.',
            'name.max' => 'O campo "nome" deve ter no máximo 100 caracteres.',
            'age.integer' => 'O campo "idade" deve ser um número inteiro.',
            'age.min' => 'O campo "idade" deve ser no mínimo 18 anos.',
            'age.max' => 'O campo "idade" deve ser no máximo 100 anos.',
            'email.email' => 'O campo "email" deve ser um endereço de e-mail válido.',
            'email.max' => 'O campo "email" deve ter no máximo 150 caracteres.',
            'phone.regex' => 'O campo "telefone" deve conter apenas números e ter entre 10 e 11 dígitos.',
            'sex.in' => 'O campo "sexo" deve ser "masculino" ou "feminino".',
            'birth.date' => 'O campo "data de nascimento" deve ser uma data válida.',
            'birth.before' => 'O campo "data de nascimento" deve ser uma data anterior a hoje.',
            'place_of_birth.max' => 'O campo "local de nascimento" deve ter no máximo 100 caracteres.',
            'city.max' => 'O campo "cidade" deve ter no máximo 100 caracteres.',
            'neighborhood.max' => 'O campo "bairro" deve ter no máximo 100 caracteres.',
            'street.max' => 'O campo "rua" deve ter no máximo 150 caracteres.',
            'block.max' => 'O campo "bloco" deve ter no máximo 10 caracteres.',
            'apartment.max' => 'O campo "apartamento" deve ter no máximo 10 caracteres.',
            'crm.regex' => 'O campo "CRM" deve começar com "CRM" seguido de números.',
            'specialty.max' => 'O campo "especialidade" deve ter no máximo 100 caracteres.',
        ];
    }


    public function prepareForValidation()
    {
        $this->merge([
            'active' => $this->active === "1" ? 1 : 0,
            'age' => (int) floor((strtotime(now()) - strtotime($this->birth)) / (60 * 60 * 24 * 365.25)),
        ]);
    }
}