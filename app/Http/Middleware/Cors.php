<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response; // Asegúrate de importar esta clase

class Cors
{
    public function handle(Request $request, Closure $next)
    {
        // Llama al siguiente middleware y almacena la respuesta
        $response = $next($request);

        // Agrega los encabezados CORS a la respuesta
        $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:5174/login'); // Cambia '*' por el origen de tu frontend si es necesario
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        return $response; // Devuelve la respuesta con los encabezados
    }
}
