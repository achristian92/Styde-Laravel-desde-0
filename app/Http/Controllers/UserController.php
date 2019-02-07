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

        return view('users.create');

    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'name' => 'required'
        ],[
            'name.required' => 'campo nombre es obligatorio'
        ]);


        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        return "Editar el id del usu {$id}";
    }
}
