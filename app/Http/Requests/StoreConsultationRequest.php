<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConsultationRequest extends FormRequest
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
            'reason_for_consultation' => 'required|string|max:255',
            'symptoms' => 'required|string|max:1000',
            'date_time' => 'required|date',
            'prescribed_medication' => 'nullable|string|max:1000',
            'medical_recommendations' => 'nullable|string|max:1000',
            'doctor_observations' => 'nullable|string|max:1000',
            'performed_procedures' => 'nullable|string|max:1000',
            'diagnosis' => 'nullable|string|max:1000',
            'additional_notes' => 'nullable|string|max:1000',
            'patient_id' => 'required|exists:patients,id',
            'flag_consultation' => 'integer'
        ];
    }

    public function messages(): array
    {
        return [
            'reason_for_consultation.required' => 'O motivo da consulta é obrigatório.',
            'reason_for_consultation.string' => 'O motivo da consulta deve ser um texto válido.',
            'reason_for_consultation.max' => 'O motivo da consulta não pode exceder 255 caracteres.',

            'symptoms.required' => 'Os sintomas são obrigatórios.',
            'symptoms.string' => 'Os sintomas devem ser um texto válido.',
            'symptoms.max' => 'Os sintomas não podem exceder 1000 caracteres.',

            'date_time.required' => 'A data e hora da consulta são obrigatórias.',
            'date_time.date' => 'A data e hora devem estar em um formato válido.',

            'prescribed_medication.string' => 'A medicação prescrita deve ser um texto válido.',
            'prescribed_medication.max' => 'A medicação prescrita não pode exceder 1000 caracteres.',

            'medical_recommendations.string' => 'As recomendações médicas devem ser um texto válido.',
            'medical_recommendations.max' => 'As recomendações médicas não podem exceder 1000 caracteres.',

            'doctor_observations.string' => 'As observações do médico devem ser um texto válido.',
            'doctor_observations.max' => 'As observações do médico não podem exceder 1000 caracteres.',

            'performed_procedures.string' => 'Os procedimentos realizados devem ser um texto válido.',
            'performed_procedures.max' => 'Os procedimentos realizados não podem exceder 1000 caracteres.',

            'diagnosis.string' => 'O diagnóstico deve ser um texto válido.',
            'diagnosis.max' => 'O diagnóstico não pode exceder 1000 caracteres.',

            'additional_notes.string' => 'As observações adicionais devem ser um texto válido.',
            'additional_notes.max' => 'As observações adicionais não podem exceder 1000 caracteres.',

            'patient_id.required' => 'O paciente é obrigatório.',
            'patient_id.exists' => 'O paciente selecionado não existe.',
        ];
    }

    public function prepareForValidation(): array
    {
        return [
            'flag_consultation' => 0, // Default value for flag_consultation
        ];
    }
}