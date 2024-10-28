<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function show($userId)
{
    // Obtener el usuario y sus productos asociados
    $user = User::with('productos')->findOrFail($userId);

    // Retornar la vista y pasarle el usuario
    return view('users.show', compact('user'));
}


}
