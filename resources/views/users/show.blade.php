@extends('layout')
@section('title',"Usuario {$user->id}")
@section('content')
    <h1>Usuario # {{ $user->id  }}</h1>

    <p>DETALLE DEL USUARIO:</p>
    <p>Nombre :{{$user->name}}</p>
    Correo : {{$user->email}}

    <p>
        <a href="{{route('users.index')}}">Regresar</a>
    </p>

@endsection
