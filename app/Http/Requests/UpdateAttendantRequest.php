<?php

namespace App\Http\Requests;

use App\Models\Adm;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendantRequest extends FormRequest
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
            'id_administrator_fk' => 'nullable|int',
            'active' => 'nullable|integer',
            'apartment' => 'nullable|string|max:10',
            'birth' => 'nullable|date|before:today',
            'block' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
            'cpf' => 'nullable|digits:11',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'email' => 'nullable|email',
            'name' => 'nullable|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6|max:255',
            'phone' => 'nullable|string|regex:/^\d{10,15}$/',
            'place_of_birth' => 'nullable|string|max:255',
            'role' => 'nullable',
            'sex' => 'nullable|in:masculino,feminino',
            'street' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'photo.image' => 'A foto deve ser uma imagem.',
            'photo.mimes' => 'A foto deve ser um arquivo do tipo: jpg, jpeg, png.',
            'photo.max' => 'A foto não pode ter mais de 4096 KB.',
            'active.integer' => 'O campo active deve ser um número inteiro.',
            'apartment.string' => 'O campo apartment deve ser uma string.',
            'apartment.max' => 'O campo apartment deve ter no máximo 10 caracteres.',
            'birth.required' => 'O campo birth é obrigatório.',
            'birth.date' => 'O campo birth deve ser uma data.',
            'birth.before' => 'O campo birth deve ser uma data anterior a hoje.',
            'block.string' => 'O campo block deve ser uma string.',
            'block.max' => 'O campo block deve ter no máximo 10 caracteres.',
            'city.required' => 'O campo city é obrigatório.',
            'city.string' => 'O campo city deve ser uma string.',
            'city.max' => 'O campo city deve ter no máximo 255 caracteres.',
            'cpf.required' => 'O campo cpf é obrigatório.',
            'cpf.digits' => 'O campo cpf deve ter 11 dígitos.',
            'cpf.unique' => 'O campo cpf já está em uso.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um email válido.',
            'id_administrator_fk.required' => 'O campo id_administrator_fk é obrigatório.',
            'id_administrator_fk.int' => 'O campo id_administrator_fk deve ser um número inteiro.',
            'id_administrator_fk.exists' => 'O campo id_administrator_fk não existe.',
            'name.required' => 'O campo name é obrigatório.',
            'name.string' => 'O campo name deve ser uma string.',
            'name.max' => 'O campo name deve ter no máximo 255 caracteres.',
            'neighborhood.string' => 'O campo neighborhood deve ser uma string.',
            'neighborhood.max' => 'O campo neighborhood deve ter no máximo 255 caracteres.',
            'password.required' => 'O campo password é obrigatório.',
            'password.string' => 'O campo password deve ser uma string.',
            'password.min' => 'O campo password deve ter no mínimo 6 caracteres.',
            'password.max' => 'O campo password deve ter no máximo 255 caracteres.',
            'phone.required' => 'O campo phone é obrigatório.',
            'phone.string' => 'O campo phone deve ser uma string.',
            'phone' => 'O campo phone deve ser um número de telefone válido.',
            'place_of_birth.required' => 'O campo place_of_birth é obrigatório.',
            'place_of_birth.string' => 'O campo place_of_birth deve ser uma string.',
            'place_of_birth.max' => 'O campo place_of_birth deve ter no máximo 255 caracteres.',
            'role.required' => 'O campo role é obrigatório.',
            'sex.in' => 'O campo sexo deve ser masculino ou feminino.',
            'active.integer' => 'O campo active deve ser um número inteiro.',
        ];
    }


    public function prepareForValidation()
    {
        $this->merge([
            'active' => $this->active === "1" || 1 ? 1 : 0,
            'age' => (int) floor((strtotime(now()) - strtotime($this->birth)) / (60 * 60 * 24 * 365.25)),

            // id_administrator_fk recebe o id do usuário que está autenticado e manda o id do administrador
            'id_administrator_fk' => (int) Adm::where('user_id', $this->id_administrator_fk)->value('id')
        ]);
    }
}