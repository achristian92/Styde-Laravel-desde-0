<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if(request()->has('empty')){ //si la peticion contiene el campo empty
            $users = [];
        }else{
            $users = [
                'Alan',
                'Julio',
                'Isabel',
                '<script>alert("Click")</script>'
            ];
        }

        $title = 'Listado de Usuarios';

        return view('users.index',compact('users','title')); //compact convierte en un array asosiativo
    }

    public function show($id)
    {
        return view('users.show',compact('id'));

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
