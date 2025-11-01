<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdmUpdateRequest extends FormRequest
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
            'active' => 'nullable|bool',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'email_verified_at' => 'nullable|date',
            'password' => 'nullable|string|min:8',
            'phone' => 'nullable|string|max:20',
            'sex' => 'nullable|in:male,female,other',
            'birth' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'place_of_birth' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'block' => 'nullable|string|max:10',
            'apartment' => 'nullable|string|max:10',
            'role' => 'nullable|string|max:50',
            'age' => 'nullable|integer|min:18',
        ];
    }


    public function messages(): array
    {
        return [
            'status.in' => 'O status deve ser "ativo" ou "inativo".',
            'name.string' => 'O nome deve ser uma string.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'email.email' => 'O e-mail deve ser válido.',
            'email.max' => 'O e-mail não pode ter mais de 255 caracteres.',
            'email_verified_at.date' => 'A data de verificação do e-mail deve ser uma data válida.',
            'password.string' => 'A senha deve ser uma string.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'phone.string' => 'O telefone deve ser uma string.',
            'phone.max' => 'O telefone não pode ter mais de 20 caracteres.',
            'sex.in' => 'O sexo deve ser "masculino", "feminino" ou "outro".',
            'birth.date' => 'A data de nascimento deve ser válida.',
            'photo.url' => 'A URL da foto deve ser válida.',
            'place_of_birth.string' => 'O local de nascimento deve ser uma string.',
            'place_of_birth.max' => 'O local de nascimento não pode ter mais de 255 caracteres.',
            'city.string' => 'A cidade deve ser uma string.',
            'city.max' => 'A cidade não pode ter mais de 255 caracteres.',
            'neighborhood.string' => 'O bairro deve ser uma string.',
            'neighborhood.max' => 'O bairro não pode ter mais de 255 caracteres.',
            'street.string' => 'A rua deve ser uma string.',
            'street.max' => 'A rua não pode ter mais de 255 caracteres.',
            'block.string' => 'O bloco deve ser uma string.',
            'block.max' => 'O bloco não pode ter mais de 10 caracteres.',
            'apartment.string' => 'O apartamento deve ser uma string.',
            'apartment.max' => 'O apartamento não pode ter mais de 10 caracteres.',
            'role.string' => 'O cargo deve ser uma string.',
            'role.max' => 'O cargo não pode ter mais de 50 caracteres.',
            'photo.image' => 'A foto deve ser uma imagem.',
            'photo.mimes' => 'A foto deve ser um arquivo do tipo: jpg, jpeg, png.',
            'photo.max' => 'A foto não pode ter mais de 4096 KB.',
        ];
    }

    function prepareForValidation()
    {
        $this->merge([
            'age' => (int) floor((strtotime(now()) - strtotime($this->birth)) / (60 * 60 * 24 * 365.25)),
            'active' => $this->has('active')  ? 1 : 0,
        ]);
    }
}