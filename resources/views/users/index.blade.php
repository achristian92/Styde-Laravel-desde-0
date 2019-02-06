@extends('layout')
@section('content')
    <h1>{{ $title }}</h1>
    <hr>
    @if(count($users)) <!--condicional inverso(a menos que la lista usuario este vacia-->
    <ul>
        @foreach ($users as $user)
            <li>{{ $user->name }}, ({{ $user->email }})</li>
        @endforeach
    </ul>
    @else
        <p>No hay Usuarios Registrados</p>
    @endif

@endsection
