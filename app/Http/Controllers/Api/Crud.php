<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class Crud extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexGlobal($model, $relacionamento = null)
    {
        $modelClass = "App\\Models\\$model";

        if (class_exists($modelClass)) {
            $relacionamento ? $modelClass = $modelClass::with($relacionamento)->get() : $modelClass = $modelClass::all();
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

            if ($user = User::create($request->all())) {
                $request['user_id'] = $user->id;

                if ($modelClass::create($request->all())) {
                    return ['status' => 'success', 'message' => 'Employee created successfully'];
                } else {
                    throw new \Exception('Error creating Employee');
                }
            } else {
                throw new \Exception('Error creating User');
            };
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Error creating Employee'];
        }
    }

    /**
     * Display the specified resource.
     */
    public function showGlobal($model)
    {
        if ($model)
            return response()->json(['status' => true, 'data' => $model], 200);

        return response()->json(['error' => 'Model not found', 'status' => false], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyGlobal($model)
    {

        if ($model->delete())
            return response()->json(['status' => true, 'message' => 'Model deleted successfully'], 200);



        return response()->json(['error' => 'Model not found', 'status' => false], 404);
    }
}