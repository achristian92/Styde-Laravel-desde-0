<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return 'Usuarios';
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
