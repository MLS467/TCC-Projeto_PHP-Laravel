<?php

namespace App\Http\Controllers\Api\Bed;

use App\Http\Controllers\Controller;
use App\Models\Bed;
use App\Models\User;
use Illuminate\Http\Request;

class JoinBetweenBedAndUser extends Controller
{
    public function __invoke(Request $request)
    {
        $user_id = $request->user_id;
        $user_test = User::find($user_id);

        if (!$user_test) {
            return response()->json(['message' => "Usuário não encontrado."], 404);
        }

        $bed_test = Bed::where('user_id', '=', $user_id)->first();

        if ($bed_test) {
            $name = $bed_test->user->name;
            $number_bed = $bed_test->number_bed;

            return response()->json(['message' => "Usuário $name já está no leito $number_bed."], 401);
        }

        $bed = Bed::where('user_id', '=', null)
            ->where('status_bed', '=', false)
            ->first();

        $bed->user_id = $user_id;
        $bed->status_bed = true;
        $bed->save();

        return response()->json(['bed' => $bed], 200);
    }
}