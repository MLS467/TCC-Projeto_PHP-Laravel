<?php

namespace App\Http\Controllers\Api\User;

use App\Exceptions\UserException;
use App\Http\Controllers\Api\Abstract\Crud;
use App\Http\Requests\UserStoredRequest;
use App\Http\traits\UploadImagemTrait;
use App\Models\Bed;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;

class UserController extends Crud
{
    use UploadImagemTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            return $this->indexGlobal('User');
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao buscar usuários',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoredRequest $request): JsonResponse
    {
        try {
            $data_validated = $request->validated();

            $user = User::updateOrCreate(
                ['cpf' => $data_validated['cpf']],
                $data_validated
            );

            if (!$user) {
                throw new UserException('Falha ao criar usuário.');
            }

            return response()->json([
                'status' => true,
                'message' => 'Usuário criado com sucesso',
                'data' => $user
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao criar usuário',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        try {
            $data = $this->showGlobal($user);

            if ($data->isEmpty())
                throw new UserException('Usuário não encontrado.', 404);

            return response()->json([
                'status' => true,
                'message' => 'Usuário encontrado com sucesso',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao buscar usuário',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {


        try {
            $user = User::findOrFail($id);
            $photo_name = $this->uploadImagem($request);

            $user->update(array_merge($request->all(), ['photo' => $photo_name]));

            if ($user) {
                return response()->json([
                    'status' => true,
                    'message' => 'Usuário atualizado com sucesso',
                    'data' => $user
                ], 200);
            }

            throw new UserException('Erro ao atualizar usuário.', 500);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar usuário',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        try {
            $hasBeds = Bed::where('user_id', $user->id)->first();

            if ($hasBeds) {
                $hasBeds->update(
                    [
                        'user_id' => null,
                        'status' => false
                    ]
                );
            }

            $data = $user->update([
                "flag" => 40028922
            ]);

            if (!$data) {
                throw new UserException('Erro ao deletar usuário.', 500);
            }

            return response()->json([
                'status' => true,
                'message' => 'Usuário excluído com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao excluir usuário',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}