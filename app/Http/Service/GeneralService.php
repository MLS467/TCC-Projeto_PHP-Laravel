<?php

namespace App\Http\Service;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class GeneralService
{
    public static function uploadFoto(Request $request): array
    {
        $file = $request->file('photo');

        try {
            // Criar instância do ImageManager
            $manager = new ImageManager(new Driver());

            // Redimensionar imagem antes do upload
            $image = $manager->read($file);
            $image->resize(300, 300);

            // Converter para formato temporário com extensão
            $tempPath = tempnam(sys_get_temp_dir(), 'resized_image') . '.jpg';
            $image->save($tempPath, 70);

            // Upload para Cloudinary com nome único
            $fileName = 'avatar_' . uniqid() . '_' . time() . '.jpg';
            Storage::disk('cloudinary')->putFileAs('avatars', $tempPath, $fileName);

            // Limpar arquivo temporário
            unlink($tempPath);

            // O Storage::disk('cloudinary')->putFileAs retorna true/false, então gere a URL manualmente
            $url = 'https://res.cloudinary.com/dyyiewmgy/image/upload/avatars/' . $fileName;

            return [
                'status' => true,
                'url' => $url
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}