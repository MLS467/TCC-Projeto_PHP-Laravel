<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Crud extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexGlobal($model, $relacionamento = null)
    {
        $modelClass = "App\\Models\\$model";

        if (class_exists($modelClass)) {
            $modelClass = $relacionamento !== null ?  $modelClass::with($relacionamento)->get() : $modelClass::all();
            return response()->json(['status' => true, 'data' => $modelClass], 200);
        }

        return response()->json(['error' => 'Model not found', 'status' => false], 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeGlobal($request, $model)
    {
        try {
            $modelClass = "App\\Models\\$model";

            if (!class_exists($modelClass)) {
                return ['status' => 'error', 'message' => 'Class not found'];
            }

            $dataValidated = $request->validated();
            if ($user = User::create($dataValidated)) {
                $dataValidated['user_id'] = $user->id;

                if ($modelClass::create($dataValidated)) {
                    return ['status' => 'success', 'message' => 'Employee created successfully'];
                } else {
                    throw new \Exception('Error creating Employee');
                }
            } else {
                throw new \Exception('Error creating User');
            };
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Display the specified resource.
     */
    public function showGlobal($model, $relacionamento = null)
    {
        if ($model) {
            $result = $relacionamento ?  $model->load($relacionamento) :   $model;
            return response()->json(['status' => true, 'data' => $result], 200);
        }

        return response()->json(['error' => 'Model not found', 'status' => false], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateGlobal($request, $model)
    {
        try {
            $user_id = $model['user_id'];

            if (User::find($user_id)->update($request->validated())) {

                if ($model->update($request->validated())) {
                    return response()->json(['status' => true, 'message' => 'Adm updated successfully', 'data' => $model->load('user')], 200);
                } else
                    throw new \Exception("Error updating Adm {$this->$model->id}");
            } else
                throw new \Exception("Error updating User $user_id");
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error updating Adm 3', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyGlobal($model)
    {
        try {
            DB::transaction(function () use ($model) {
                // Verifica se o modelo e o user_id são válidos
                if (!$model || !$model['user_id']) {
                    throw new \Exception("Invalid model or user ID");
                }

                $user = User::find($model['user_id']);

                // Verifica se o usuário existe
                if (!$user) {
                    throw new \Exception("User with ID {$model['user_id']} not found");
                }

                // Exclui o usuário e o modelo
                $user->delete();
                $model->delete();
            });

            return response()->json(['status' => true, 'message' => 'Model deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error deleting model', 'error' => $e->getMessage()], 500);
        }
    }
}