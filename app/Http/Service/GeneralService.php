<?php

namespace App\Http\Service;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GeneralService
{
    public static function uploadFoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $file = $request->file('photo');

        try {
            $path = Storage::disk('cloudinary')->put('avatars', $file);

            $url = $path;

            // Se quiser salvar no banco, exemplo:
            // Paciente::where('id', $id)->update(['foto_url' => $url]);

            return response()->json([
                'message' => 'Upload realizado com sucesso',
                'url' => $url
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro no upload',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}