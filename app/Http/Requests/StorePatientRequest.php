<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
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
            'user_id' => 'required|integer',
            'flag_triage' => 'required|integer',
            'heart_rate' => 'nullable|integer|min:0',
            'respiratory_rate' => 'nullable|integer|min:0',
            'oxygen_saturation' => 'nullable|integer|min:0|max:100',
            'temperature' => 'nullable|numeric|min:25|max:45',
            'chief_complaint' => 'nullable|string|max:255',
            'responsible_name' => 'nullable|string|max:255',
            'sugery_history' => 'nullable|string|max:500',
            'blood_type' => 'nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'blood_pressure' => 'nullable|numeric',
            'difficulty_breathing' => 'nullable|boolean',
            'vomiting' => 'nullable|boolean',
            'surgical_history' => 'nullable|string|max:500',
            'edema' => 'nullable|boolean',
            'nausea' => 'nullable|boolean',
            'patient_condition' => 'string',
            'bleeding' => 'nullable|boolean',
            'allergy' => 'nullable|string|max:500',
            'emergency_phone' => 'nullable|string|regex:/^\d{8,15}$/',
            'flag_consultation' => 'integer',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'O campo ID do usuário é obrigatório.',
            'user_id.integer' => 'O ID do usuário deve ser um número inteiro.',
            'heart_rate.integer' => 'A frequência cardíaca deve ser um número inteiro.',
            'heart_rate.min' => 'A frequência cardíaca não pode ser menor que 0.',
            'respiratory_rate.integer' => 'A frequência respiratória deve ser um número inteiro.',
            'oxygen_saturation.integer' => 'A saturação de oxigênio deve ser um número inteiro.',
            'oxygen_saturation.min' => 'A saturação de oxigênio não pode ser menor que 0.',
            'oxygen_saturation.max' => 'A saturação de oxigênio não pode ser maior que 100.',
            'temperature.numeric' => 'A temperatura deve ser um número.',
            'temperature.min' => 'A temperatura mínima permitida é 25°C.',
            'temperature.max' => 'A temperatura máxima permitida é 45°C.',
            'chief_complaint.string' => 'A queixa principal deve ser uma string.',
            'chief_complaint.max' => 'A queixa principal não pode ultrapassar 255 caracteres.',
            'responsible_name.string' => 'O nome do responsável deve ser uma string.',
            'responsible_name.max' => 'O nome do responsável não pode ultrapassar 255 caracteres.',
            'blood_type.in' => 'O tipo sanguíneo deve ser um dos seguintes: A+, A-, B+, B-, AB+, AB-, O+, O-.',
            'difficulty_breathing.boolean' => 'A dificuldade para respirar deve ser um valor booleano.',
            'vomiting.boolean' => 'O campo de vômito deve ser um valor booleano.',
            'edema.boolean' => 'O campo de edema deve ser um valor booleano.',
            'nausea.boolean' => 'O campo de náusea deve ser um valor booleano.',
            'bleeding.boolean' => 'O campo de hemorragias deve ser um valor booleano.',
            'surgical_history.string' => 'O histórico cirúrgico deve ser uma string.',
            'surgical_history.max' => 'O histórico cirúrgico não pode ultrapassar 500 caracteres.',
            'allergy.string' => 'As alergias devem ser uma string.',
            'allergy.max' => 'As alergias não podem ultrapassar 500 caracteres.',
            'emergency_phone.regex' => 'O telefone de emergência deve ser um número entre 8 e 15 dígitos.',
            'flag_consultation' => 'O campo flag_consultation é obrigatório.',
        ];
    }


    public function prepareForValidation()
    {
        $this->merge([
            'flag_triage' => 1,
            'age' => (int) floor((strtotime(now()) - strtotime($this->birth)) / (60 * 60 * 24 * 365.25)),
            'bleeding' => $this->has('bleeding')  ? 1 : 0,
            'difficulty_breathing' => $this->has('difficulty_breathing') ? 1 : 0,
            'edema' => $this->edema  ? 1 : 0,
            'nausea' => $this->nausea ? 1 : 0,
            'vomiting' => $this->vomiting ? 1 : 0,
        ]);
    }
}