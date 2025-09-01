<?php

namespace App\Http\Controllers\Api\User;

use App\Exceptions\UserException;
use App\Http\Controllers\Api\Abstract\Crud;
use App\Http\Requests\UserStoredRequest;
use App\Http\traits\UploadImagemTrait;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Exception;

class UserController extends Crud
{
    use UploadImagemTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return $this->indexGlobal('User');
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching users',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoredRequest $request)
    {
        try {

            $photo_name = $this->uploadImagem($request);

            $data_validated = $request->validated();

            $data_validated['photo'] = $photo_name;

            $user = User::create($data_validated);

            if (!$user) {
                throw new UserException('Falha ao criar usuário.');
            }

            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                'data' => $user
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        try {
            $data = $this->showGlobal($user);

            if ($data->isEmpty())
                throw new UserException('Usuário não encontrado.', 404);

            return response()->json([
                'status' => true,
                'message' => 'User fetched successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching user',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $photo_name = $this->uploadImagem($request);
            $user->update(array_merge($request->all(), ['photo' => $photo_name]));

            if ($user) {
                return response()->json([
                    'status' => true,
                    'message' => 'User updated successfully',
                    'data' => $user
                ], 200);
            }

            throw new UserException('Erro ao atualizar usuário.', 500);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error updating user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $data = $this->destroyGlobal($user);

            if (!$data) {
                throw new UserException('Erro ao deletar usuário.', 500);
            }

            return response()->json([
                'status' => true,
                'message' => 'User deleted successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error deleting user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}