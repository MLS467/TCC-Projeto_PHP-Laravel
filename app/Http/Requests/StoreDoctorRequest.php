<?php

namespace App\Http\Requests;

use App\Models\Adm;
use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
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
            'active' => 'required|integer',
            'role' => 'required|string|in:doctor,nurse,attendant',
            'id_administrator_fk' => 'integer',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'name' => 'required|string|min:3|max:100',
            'age' => 'required|integer|min:18|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|regex:/^\d{10,11}$/',
            'password' => 'required|string|min:8|max:20',
            'cpf' => 'required',
            'sex' => 'required|string|in:masculino,feminino',
            'birth' => 'required|date|before:today',
            'place_of_birth' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'neighborhood' => 'required|string|max:100',
            'street' => 'required|string|max:150',
            'block' => 'nullable|string|max:10',
            'apartment' => 'nullable|string|max:10',
            'crm' => 'required|string|regex:/^CRM\d+$/',
            'specialty' => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'O campo "senha" é obrigatório.',
            'id_administrator_fk' => 'O campo "id_administrator_fk" é obrigatório.',
            'password.min' => 'O campo "senha" deve ter pelo menos 8 caracteres.',
            'password.max' => 'O campo "senha" não pode ter mais de 20 caracteres.',
            'role.required' => 'O campo "role" é obrigatório.',
            'role.in' => 'O campo "role" deve ser um dos seguintes valores: doctor, nurse ou attendant.',
            'name.required' => 'O campo "nome" é obrigatório.',
            'name.min' => 'O campo "nome" deve ter pelo menos 3 caracteres.',
            'name.max' => 'O campo "nome" não pode ter mais de 100 caracteres.',
            'age.required' => 'O campo "idade" é obrigatório.',
            'age.integer' => 'O campo "idade" deve ser um número inteiro.',
            'age.min' => 'A idade deve ser de pelo menos 18 anos.',
            'photo.required' => 'A foto do médico é obrigatória.',
            'photo.image' => 'O arquivo enviado deve ser uma imagem.',
            'photo.mimes' => 'A foto deve estar no formato JPG, JPEG ou PNG.',
            'photo.max' => 'A foto não pode exceder o tamanho máximo de 4096 KB.',
            'age.max' => 'A idade não pode exceder 100 anos.',
            'email.required' => 'O campo "email" é obrigatório.',
            'email.email' => 'O campo "email" deve conter um endereço de email válido.',
            'email.max' => 'O campo "email" não pode ter mais de 150 caracteres.',
            'phone.required' => 'O campo "telefone" é obrigatório.',
            'phone.regex' => 'O telefone deve conter 10 ou 11 dígitos numéricos.',
            'cpf.required' => 'O campo "CPF" é obrigatório.',
            'cpf.cpf' => 'O CPF informado é inválido.',
            'sex.required' => 'O campo "sexo" é obrigatório.',
            'sex.in' => 'O campo "sexo" deve ser um dos seguintes valores: masculino, feminino ou outro.',
            'birth.required' => 'O campo "data de nascimento" é obrigatório.',
            'birth.date' => 'O campo "data de nascimento" deve ser uma data válida.',
            'birth.before' => 'A data de nascimento deve ser anterior à data atual.',
            'place_of_birth.required' => 'O campo "local de nascimento" é obrigatório.',
            'place_of_birth.max' => 'O campo "local de nascimento" não pode ter mais de 100 caracteres.',
            'city.required' => 'O campo "cidade" é obrigatório.',
            'city.max' => 'O campo "cidade" não pode ter mais de 100 caracteres.',
            'neighborhood.required' => 'O campo "bairro" é obrigatório.',
            'neighborhood.max' => 'O campo "bairro" não pode ter mais de 100 caracteres.',
            'street.required' => 'O campo "rua" é obrigatório.',
            'street.max' => 'O campo "rua" não pode ter mais de 150 caracteres.',
            'block.max' => 'O campo "bloco" não pode ter mais de 10 caracteres.',
            'apartment.max' => 'O campo "apartamento" não pode ter mais de 10 caracteres.',
            'crm.required' => 'O campo "CRM" é obrigatório.',
            'crm.regex' => 'O campo "CRM" deve começar com "CRM" seguido de números.',
            'specialty.required' => 'O campo "especialidade" é obrigatório.',
            'specialty.max' => 'O campo "especialidade" não pode ter mais de 100 caracteres.',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'role' => 'doctor',
            'active' => $this->has('active') ? 1 : 0,
            'age' => (int) floor((strtotime(now()) - strtotime($this->birth)) / (60 * 60 * 24 * 365.25)),

            // id_administrator_fk recebe o id do usuário que está autenticado e manda o id do administrador
            'id_administrator_fk' => (int) Adm::where('user_id', $this->id_administrator_fk)->value('id')
        ]);
    }
}