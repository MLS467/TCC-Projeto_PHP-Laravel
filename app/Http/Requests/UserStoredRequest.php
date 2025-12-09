<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoredRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'flag' => 'required|integer',
            'email' => 'required|email|max:255',
            'email_verified_at' => 'nullable|date',
            'password' => 'required|string|min:8',
            'phone' => 'required|regex:/^\d{10,15}$/',
            'cpf' => 'required|regex:/^\d{11}$/',
            'sex' => 'required|in:masculino,feminino,outro',
            'birth' => 'required|date',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'place_of_birth' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'block' => 'nullable|string|max:50',
            'apartment' => 'nullable|string|max:50',
            'role' => 'required|string|max:50',
            'age' => 'required|integer|min:0|max:120',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome deve ter no máximo 255 caracteres.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O campo e-mail deve conter um endereço válido.',
            'email.max' => 'O campo e-mail deve ter no máximo 255 caracteres.',
            'email_verified_at.date' => 'O campo de verificação de e-mail deve ser uma data válida.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.string' => 'O campo senha deve ser uma string.',
            'password.min' => 'O campo senha deve ter no mínimo 8 caracteres.',
            'phone.regex' => 'O campo telefone deve conter apenas números entre 10 e 15 dígitos.',
            'cpf.required' => 'O campo CPF é obrigatório.',
            'cpf.regex' => 'O campo CPF deve conter 11 dígitos.',
            'sex.required' => 'O campo sexo é obrigatório.',
            'sex.in' => 'O campo sexo deve ser masculino, feminino ou outro.',
            'birth.required' => 'O campo data de nascimento é obrigatório.',
            'birth.date' => 'O campo data de nascimento deve ser uma data válida.',
            'photo.image' => 'O campo foto deve ser uma imagem.',
            'photo.max' => 'O campo foto deve ter no máximo 2MB.',
            'place_of_birth.string' => 'O campo local de nascimento deve ser uma string.',
            'place_of_birth.max' => 'O campo local de nascimento deve ter no máximo 255 caracteres.',
            'city.required' => 'O campo cidade é obrigatório.',
            'city.string' => 'O campo cidade deve ser uma string.',
            'city.max' => 'O campo cidade deve ter no máximo 255 caracteres.',
            'neighborhood.string' => 'O campo bairro deve ser uma string.',
            'neighborhood.max' => 'O campo bairro deve ter no máximo 255 caracteres.',
            'street.string' => 'O campo rua deve ser uma string.',
            'street.max' => 'O campo rua deve ter no máximo 255 caracteres.',
            'block.string' => 'O campo bloco deve ser uma string.',
            'block.max' => 'O campo bloco deve ter no máximo 50 caracteres.',
            'apartment.string' => 'O campo apartamento deve ser uma string.',
            'apartment.max' => 'O campo apartamento deve ter no máximo 50 caracteres.',
            'role.required' => 'O campo função é obrigatório.',
            'role.string' => 'O campo função deve ser uma string.',
            'role.max' => 'O campo função deve ter no máximo 50 caracteres.',
            'age.required' => 'O campo idade é obrigatório.',
            'age.integer' => 'O campo idade deve ser um número inteiro.',
            'age.min' => 'O campo idade deve ser maior ou igual a 0.',
            'age.max' => 'O campo idade deve ser menor ou igual a 120.',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'flag' => 0,
            'age' => (int) floor((strtotime(now()) - strtotime($this->birth)) / (60 * 60 * 24 * 365.25)),
            'password' => $this->has('password') ? bcrypt($this->password) : bcrypt(0),
        ]);
    }
}