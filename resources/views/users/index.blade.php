@extends('layout')
@section('content')
    <h1>{{ $title }}</h1>
    <hr>
    @unless(empty($users)) <!--condicional inverso(a menos que la lista usuario este vacia-->
    <ul>
        @foreach ($users as $user)
            <li>{{ $user->name }}</li>
        @endforeach
    </ul>
    @else
        <p>No hay Usuarios Registrados</p>
    @endunless

@endsection
