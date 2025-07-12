<?php

namespace App\Http\traits;

use Illuminate\Http\Request;

trait UploadImagemTrait
{
    /**
     * Faz o upload da imagem se ela estiver presente no request.
     * Retorna o nome do arquivo salvo ou null se não houver imagem.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $campo Nome do campo do input (default: 'imagem')
     * @param string $pasta Pasta dentro de public/ para salvar a imagem (default: 'images')
     * @return string|null
     */
    public function uploadImagem(Request $request, $campo = 'photo', $pasta = 'users')
    {
        if (!$request->hasFile($campo) || !$request->file($campo)->isValid()) {
            return null;
        }

        $imagem = $request->file($campo);
        $nomeImagem = time() . '.' . $imagem->getClientOriginalExtension();

        // Salva na pasta storage/app/users
        $imagem->storeAs("{$pasta}", $nomeImagem);

        return $nomeImagem; // retorna apenas o nome do arquivo
    }
}