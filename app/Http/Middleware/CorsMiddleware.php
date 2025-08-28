<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Lista de origens permitidas
        $allowedOrigins = [
            'https://atendebem.netlify.app',
            'https://www.atendebem.netlify.app',
            'http://localhost:5173',
            'http://127.0.0.1:5173',
            'http://localhost:3000',
            'http://127.0.0.1:3000',
            'http://localhost:8080',
            'http://127.0.0.1:8080',
        ];

        $origin = $request->headers->get('origin');

        // Verifica se a origem está na lista permitida ou se é um subdomínio do Netlify
        $isAllowed = in_array($origin, $allowedOrigins) || 
                    (str_contains($origin, '.netlify.app') && str_starts_with($origin, 'https://'));

        // Handle preflight OPTIONS request
        if ($request->getMethod() === "OPTIONS") {
            $response = response('', 200);
        } else {
            $response = $next($request);
        }

        // Adiciona os headers CORS se a origem for permitida
        if ($isAllowed) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
        }

        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS, PATCH');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, Accept, Origin, X-CSRF-TOKEN');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Max-Age', '86400');

        return $response;
    }
}