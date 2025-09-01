<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserGetImageProtectedController extends Controller
{
    public function __invoke(string $filename)
    {
        $caminho = "users/{$filename}";

        if (!Storage::disk('local')->exists($caminho)) {
            abort(404);
        }


        $arquivo = Storage::disk('local')->get($caminho);
        $tipoMime = Storage::mimeType($caminho);

        return response($arquivo)->header('Content-Type', $tipoMime);
    }
}