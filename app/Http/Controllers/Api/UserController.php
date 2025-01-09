<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoredRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Crud
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->indexGlobal('User');
    }

    public function UserPatient()
    {
        return User::where('role', 'patient')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoredRequest $request)
    {

        if (User::create($request->validated())) {
            return response()->json([
                'status' => true,
                'message' => 'User created successfully'
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Error creating user'
            ], 400);
        };
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->showGlobal($user);
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
    public function destroy(User $user)
    {
        return $this->destroyGlobal($user);
    }
}