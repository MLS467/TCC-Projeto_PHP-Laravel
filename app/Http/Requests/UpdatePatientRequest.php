<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
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
            'emergency_phone' => 'nullable|string',
            'sugery_history' => 'nullable|string',
            'allergy' => 'nullable|string',
            'blood_type' => 'nullable|string',
            'blood_pressure' => 'nullable|numeric',
            'heart_rate' => 'nullable|numeric',
            'respiratory_rate' => 'nullable|numeric',
            'oxygen_saturation' => 'nullable|numeric',
            'temperature' => 'nullable|numeric',
            'chief_complaint' => 'nullable|string',
            'flag_triage' => 'required|in:0,1',
            'difficulty_breathing' => 'nullable|integer',
            'vomiting' => 'nullable|integer',
            'edema' => 'nullable|integer',
            'nausea' => 'nullable|integer',
            'bleeding' => 'nullable|integer',
            'responsible_specialist' => 'nullable|string|max:100'
        ];
    }

    /**
     * Prepare the data for validation.
     * 
     */
    public function prepareForValidation()
    {
        $this->merge([
            'flag_triage' => 1,
            'bleeding' => $this->bleeding  ? 1 : 0,
            'difficulty_breathing' => $this->difficulty_breathing ? 1 : 0,
            'edema' => $this->edema  ? 1 : 0,
            'nausea' => $this->nausea ? 1 : 0,
            'vomiting' => $this->vomiting ? 1 : 0
        ]);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        // me de todas validações que ainda não foram feitas
        return [


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
            'emergency_phone.string' => 'O telefone de emergência deve ser válido.',
            'blood_pressure.numeric' => 'A pressão arterial deve ser um número.',
            'heart_rate.numeric' => 'A frequência cardíaca deve ser um número.',
            'respiratory_rate.numeric' => 'A frequência respiratória deve ser um número.',
            'oxygen_saturation.numeric' => 'A saturação de oxigênio deve ser um número.',
            'temperature.numeric' => 'A temperatura deve ser um número.',
            'flag_triage.required' => 'O flag de triagem é obrigatório.',
            'flag_triage.in' => 'O flag de triagem deve ser 0 ou 1.',
            'responsible_specialist.max' => 'O campo "especialista responsável" deve ter no máximo 100 caracteres.',

        ];
    }
}