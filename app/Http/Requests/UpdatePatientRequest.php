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
            'triage_flag' => 'required|in:0,1',
            'difficulty_breathing' => 'nullable|integer',
            'vomiting' => 'nullable|integer',
            'edema' => 'nullable|integer',
            'nausea' => 'nullable|integer',
            'bleeding' => 'nullable|integer',
        ];
    }

    /**
     * Prepare the data for validation.
     * 
     */
    public function prepareForValidation()
    {
        dd($this->all());
        $this->merge([
            'triage_flag' => 1,
            'bleeding' => $this->has('bleeding')  ? 1 : 0,
            'difficulty_breathing' => $this->has('difficulty_breathing') ? 1 : 0,
            'edema' => $this->has('edema')  ? 1 : 0,
            'nausea' => $this->has('nausea') ? 1 : 0,
            'vomiting' => $this->has('vomiting') ? 1 : 0
        ]);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'emergency_phone.string' => 'O telefone de emergência deve ser válido.',
            'blood_pressure.numeric' => 'A pressão arterial deve ser um número.',
            'heart_rate.numeric' => 'A frequência cardíaca deve ser um número.',
            'respiratory_rate.numeric' => 'A frequência respiratória deve ser um número.',
            'oxygen_saturation.numeric' => 'A saturação de oxigênio deve ser um número.',
            'temperature.numeric' => 'A temperatura deve ser um número.',
            'triage_flag.required' => 'O flag de triagem é obrigatório.',
            'triage_flag.in' => 'O flag de triagem deve ser 0 ou 1.',
        ];
    }
}