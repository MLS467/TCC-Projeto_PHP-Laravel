<?php

namespace App\Http\Controllers\Api\Abstract;

use App\Http\Controllers\Controller;
use App\Http\Service\GeneralService;
use App\Models\User;
use Illuminate\Support\Facades\DB;

abstract class Crud extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexGlobal($model, $relacionamento = null)
    {
        try {
            $modelClass = "App\\Models\\$model";

            if (class_exists($modelClass)) {
                $modelClass = $relacionamento !== null ?  $modelClass::with($relacionamento)->get() : $modelClass::all();

                if (!$modelClass)
                    throw new \Exception('Model not found');

                return response()->json(['status' => true, 'data' => $modelClass], 200);
            } else
                throw new \Exception('Model not found');
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            return response()->json(['error' => 'Model not found', 'status' => false, "message" => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred', 'status' => false, "message" => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeGlobal($request, $model)
    {
        try {
            DB::transaction(function () use ($request, $model) {
                $modelClass = "App\\Models\\$model";

                if (!class_exists($modelClass)) {
                    throw new \Exception('Model not found');
                }

                $dataValidated = $request->validated();


                $result_photo = GeneralService::uploadFoto($request);

                $photo_name = "https://res.cloudinary.com/dyyiewmgy/image/upload/v1762111545/not_found_ml4qgi.jpg";

                if ($result_photo['status']) {
                    $photo_name = $result_photo['url'];
                }


                // Inserir a URL da foto nos dados validados para que seja persistida no usuário
                $dataValidated['photo'] = $photo_name;

                $user = User::create($dataValidated);

                if ($user) {
                    $dataValidated['user_id'] = $user->id;
                    $modelInstance  = $modelClass::create($dataValidated);

                    if (!$modelInstance) {
                        throw new \Exception('Error creating Model');
                    }
                } else {
                    throw new \Exception('Error creating User');
                };
            });

            return response()->json(['status' => 'success', 'message' => 'Employee created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
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

            $dataValidated = $request->validated();


            $result_photo = GeneralService::uploadFoto($request);

            $photo_name = "https://res.cloudinary.com/dyyiewmgy/image/upload/v1762111545/not_found_ml4qgi.jpg";

            if ($result_photo['status']) {
                $photo_name = $result_photo['url'];
            }

            $dataValidated['photo'] = $photo_name;

            if (User::find($user_id)->update($dataValidated)) {

                if ($model->update($dataValidated)) {
                    return response()->json(['status' => true, 'message' => 'updated successfully', 'data' => $model->load('user')], 200);
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
                if (!$model || !$model['id']) {
                    throw new \Exception("Invalid model or user ID");
                }

                if ($model['flag'] === 0) {
                    $user = User::find($model['id']);
                } else {
                    $user = User::find($model['user']['id']);
                }

                if (!$user) {
                    throw new \Exception("User with ID {$model['id']} not found");
                }

                $user->delete();
                $model->delete();
            });

            return response()->json(['status' => true, 'message' => 'Model deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error deleting model', 'error' => $e->getMessage()], 500);
        }
    }
}