<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        $title = 'Listado de Usuarios';

        return view('users.index',compact('users','title')); //compact convierte en un array asosiativo
    }

    public function show(User $user)
    {
        return view('users.show',compact('user'));

    }

    public function create()
    {
        return 'Crear nuevo Usuario';

    }

    public function edit($id)
    {
        return "Editar el id del usu {$id}";
    }
}
