@extends('layout')
@section('title',"Crear Usuario")
@section('content')
    <h1>Crear nuevo Usuario</h1>

    <form action="{{route('users.store')}}" method="post">
        {!! csrf_field()!!}

        <label for="name">Nombre :</label>
        <input type="text" name="name" id="name">
        <br>
        <label>Email</label>
        <input type="email" name="email">
        <br>
        <label>Password</label>
        <input type="password" name="password">
        <br>
        <button type="submit">Crear Usuario</button>

    </form>
    <p>
        <a href="{{route('users.index')}}">Regresar</a>
    </p>

@endsection
