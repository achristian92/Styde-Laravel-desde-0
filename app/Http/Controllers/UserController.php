<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = [
          'Alan',
          'Julio',
          'Isabel',
          '<script>alert("Click")</script>'
        ];
        $title = 'Listado de Usuarios';

        return view('users',compact('users','title')); //compact convierte en un array asosiativo
    }

    public function show($id)
    {
        return "Detalle del usuario {$id}";

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
