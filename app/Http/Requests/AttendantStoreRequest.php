<?php

namespace App\Http\Requests;

use App\Models\Adm;
use Illuminate\Foundation\Http\FormRequest;

class AttendantStoreRequest extends FormRequest
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
            'apartment' => 'nullable|string|max:10',
            'birth' => 'required|date|before:today',
            'block' => 'nullable|string|max:10',
            'city' => 'required|string|max:255',
            'cpf' => 'required|digits:11|unique:users,cpf',
            'email' => 'required|email',
            'id_administrator_fk' => 'required|int|exists:adms,id',
            'name' => 'required|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'password' => 'required|string|min:6|max:255',
            'phone' => 'required|string|regex:/^\d{10,15}$/',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'place_of_birth' => 'required|string|max:255',
            'role' => 'required',
            'sex' => 'required|in:masculino,feminino',
            'street' => 'nullable|string|max:255',
        ];
    }
    public function messages()
    {
        return [
            'active.int' => 'O campo ativo deve ser um número inteiro.',
            'apartment.string' => 'O campo apartamento deve ser uma string.',
            'apartment.max' => 'O campo apartamento deve ter no máximo 10 caracteres.',
            'birth.required' => 'O campo nascimento é obrigatório.',
            'birth.date' => 'O campo nascimento deve ser uma data.',
            'birth.before' => 'O campo nascimento deve ser uma data anterior a hoje.',
            'block.string' => 'O campo bloco deve ser uma string.',
            'block.max' => 'O campo bloco deve ter no máximo 10 caracteres.',
            'city.required' => 'O campo cidade é obrigatório.',
            'city.string' => 'O campo cidade deve ser uma string.',
            'city.max' => 'O campo cidade deve ter no máximo 255 caracteres.',
            'cpf.required' => 'O campo cpf é obrigatório.',
            'cpf.digits' => 'O campo cpf deve ter 11 dígitos.',
            'cpf.unique' => 'O campo cpf já está em uso.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um email válido.',
            'id_administrator_fk.required' => 'O campo id administrador é obrigatório.',
            'id_administrator_fk.int' => 'O campo id administrador deve ser um número inteiro.',
            'id_administrator_fk.exists' => 'O campo id administrador não existe.',
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome deve ter no máximo 255 caracteres.',
            'neighborhood.string' => 'O campo bairro deve ser uma string.',
            'neighborhood.max' => 'O campo bairro deve ter no máximo 255 caracteres.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.string' => 'O campo senha deve ser uma string.',
            'password.min' => 'O campo senha deve ter no mínimo 6 caracteres.',
            'password.max' => 'O campo senha deve ter no máximo 255 caracteres.',
            'phone.required' => 'O campo telefone é obrigatório.',
            'photo.image' => 'A foto deve ser uma imagem.',
            'photo.mimes' => 'A foto deve ser um arquivo do tipo: jpg, jpeg, png.',
            'photo.max' => 'A foto não pode ter mais de 4096 KB.',
            'phone.string' => 'O campo telefone deve ser uma string.',
            'phone.regex' => 'O campo telefone deve ser um número válido.',
            'place_of_birth.required' => 'O campo local de nascimento é obrigatório.',
            'place_of_birth.string' => 'O campo local de nascimento deve ser uma string.',
            'place_of_birth.max' => 'O campo local de nascimento deve ter no máximo 255 caracteres.',
            'role.required' => 'O campo função é obrigatório.',
        ];
    }


    function prepareForValidation()
    {
        $this->merge([
            'age' => (int) floor((strtotime(now()) - strtotime($this->birth)) / (60 * 60 * 24 * 365.25)),
            'active' => $this->has('active')  ? 1 : 0,
            'id_administrator_fk' => (int) Adm::where('user_id', $this->id_administrator_fk)->value('id')
        ]);
    }
}