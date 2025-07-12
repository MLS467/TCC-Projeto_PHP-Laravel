<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserStoredRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Crud
{

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

    public function userFlag()
    {
        try {
            return User::where([['flag', '=', '0'], ['role', '=', 'patient']])->get();
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching flagged users',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function UserPatient()
    {
        try {
            return User::where('role', 'patient')->get();
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching patient users',
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
            $user = User::create($request->validated());

            if ($user) {
                return response()->json([
                    'status' => true,
                    'message' => 'User created successfully',
                    'data' => $user
                ], 201);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Error creating user'
                ], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error creating user',
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
            return $this->showGlobal($user);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function cpf_verification($cpf)
    {
        try {
            $user = User::where('cpf', $cpf)->get();

            if ($user->isEmpty()) {
                throw new \Illuminate\Database\Eloquent\ModelNotFoundException('Patient not found');
            }

            return response()->json([
                'status' => true,
                'message' => 'Patient found',
                'data' => $user
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'User updated successfully',
                'data' => $user
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
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
            $this->destroyGlobal($user);
            return response()->json([
                'status' => true,
                'message' => 'User deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error deleting user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}