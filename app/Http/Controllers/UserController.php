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

    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'email'=> 'required|email|unique:users,email',
            'password' => 'required'
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

    public function edit(User $user)
    {

        return view('users.edit',compact('user'));
    }

    public function update(User $user)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => ''
        ]);
        if($data['password'] != null){
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }
        $user->update($data);
        return redirect()->route('users.show',compact('user'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        
        return redirect()->route('users.index');
    }
}
