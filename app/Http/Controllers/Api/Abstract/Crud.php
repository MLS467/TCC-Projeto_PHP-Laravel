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
                    throw new \Exception('Modelo não encontrado');

                return response()->json(['status' => true, 'data' => $modelClass], 200);
            } else
                throw new \Exception('Modelo não encontrado');
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            return response()->json(['error' => 'Modelo não encontrado', 'status' => false, "message" => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocorreu um erro', 'status' => false, "message" => $e->getMessage()], 500);
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
                    throw new \Exception('Modelo não encontrado');
                }

                $dataValidated = $request->validated();

                $result_photo = GeneralService::uploadFoto($request);

                $photo_name = $this->addAvatarForEmployee($request);


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
                        throw new \Exception('Erro ao criar Modelo');
                    }
                } else {
                    throw new \Exception('Erro ao criar Usuário');
                };
            });

            return response()->json(['status' => 'success', 'message' => 'Funcionário criado com sucesso'], 201);
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

        return response()->json(['error' => 'Modelo não encontrado', 'status' => false], 404);
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

            if ($result_photo['status']) {
                $dataValidated['photo'] = $result_photo['url'];
            }

            if (User::find($user_id)->update($dataValidated)) {

                if ($model->update($dataValidated)) {
                    return response()->json(['status' => true, 'message' => 'atualizado com sucesso', 'data' => $model->load('user')], 200);
                } else
                    throw new \Exception("Erro ao atualizar Adm {$this->$model->id}");
            } else
                throw new \Exception("Erro ao atualizar Usuário $user_id");
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erro ao atualizar Adm', 'error' => $e->getMessage()], 500);
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
                    throw new \Exception("Modelo ou ID de usuário inválido");
                }

                if ($model['flag'] === 0) {
                    $user = User::find($model['id']);
                } else {
                    $user = User::find($model['user']['id']);
                }

                if (!$user) {
                    throw new \Exception("Usuário com ID {$model['id']} não encontrado");
                }

                $user->delete();
                $model->delete();
            });

            return response()->json(['status' => true, 'message' => 'Modelo excluído com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erro ao excluir modelo', 'error' => $e->getMessage()], 500);
        }
    }


    private function addAvatarForEmployee($request)
    {
        switch (strtolower($request->role)) {
            case 'nurse':
                if ($request->sex === 'masculino') {
                    return  "https://res.cloudinary.com/dyyiewmgy/image/upload/v1762124908/b7b0eb19-3c98-4ffe-9e33-ad4c92d3bc4e.png";
                }
                return  "https://res.cloudinary.com/dyyiewmgy/image/upload/v1762124825/37f366d7-01f6-4f0c-a589-98e0850422ff.png";

            case 'attendant':
                if ($request->sex === 'masculino') {
                    return  "https://res.cloudinary.com/dyyiewmgy/image/upload/v1762125094/098ff745-7d12-48bc-9bb9-8d24cd9a84ee.png";
                }
                return  "https://res.cloudinary.com/dyyiewmgy/image/upload/v1762125081/e2ddccb0-b14f-4705-a049-c21e3aea0ee1.png";

            case 'doctor':
                if ($request->sex === 'masculino') {
                    return  "https://res.cloudinary.com/dyyiewmgy/image/upload/v1762125162/6788a027-7ef3-4168-90ff-24ce18c07452.png";
                }
                return  "https://res.cloudinary.com/dyyiewmgy/image/upload/v1762125191/75d985ac-0eda-4308-be3e-6d3cbfde7f6b.png";

            case 'admin':
                if ($request->sex === 'masculino') {
                    return  "https://res.cloudinary.com/dyyiewmgy/image/upload/v1762125387/f162d97e-c7aa-4c84-86aa-49711b3a5233.png";
                }
                return  "https://res.cloudinary.com/dyyiewmgy/image/upload/v1762125422/dc929a03-bcea-43a7-b9e5-dee152418cdc.png";

            default:
                return  "https://res.cloudinary.com/dyyiewmgy/image/upload/v1762111545/not_found_ml4qgi.jpg";
        }
    }
}