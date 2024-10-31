<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function testToken(Request $request)
    {
        // Verifica que el usuario esté autenticado
        if ($request->user()) {
            return response()->json(['message' => 'User is authenticated']);
        }

        return response()->json(['error' => 'No user found'], 401);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Obtén el usuario autenticado
            $user = Auth::user();

            // Crea un token para el usuario autenticado
            $token = $user->createToken('YourAppName')->plainTextToken;

            // Devuelve el token y el usuario en la respuesta
            return response()->json([
                'token' => $token,
                'user' => $user,
            ]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
