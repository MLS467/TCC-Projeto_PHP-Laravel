<?php

namespace App\Http\Controllers\Api\Bed;

use App\Http\Controllers\Controller;
use App\Models\Bed;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class BedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $beds = Bed::with('user')
                ->orderBy('number_bed')
                ->get();
            return response()->json([
                'success' => true,
                'data' => $beds
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar camas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'number_bed' => 'required|integer|unique:beds,number_bed',
                'status_bed' => 'required|string|in:available,occupied,maintenance',
                'user_id' => 'nullable|exists:users,id'
            ]);

            $bed = Bed::create($validated);
            $bed->load('user');

            return response()->json([
                'success' => true,
                'message' => 'Cama criada com sucesso',
                'data' => $bed
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar cama',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $bed = Bed::with('user')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $bed
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cama não encontrada',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $bed = Bed::findOrFail($id);

            $validated = $request->validate([
                'number_bed' => 'sometimes|required|integer|unique:beds,number_bed,' . $id,
                'status_bed' => 'sometimes|required|string|in:available,occupied,maintenance',
                'user_id' => 'nullable|exists:users,id'
            ]);

            $bed->update($validated);
            $bed->load('user');

            return response()->json([
                'success' => true,
                'message' => 'Cama atualizada com sucesso',
                'data' => $bed
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar cama',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $bed = Bed::findOrFail($id);
            $bed->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cama deletada com sucesso'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao deletar cama',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}