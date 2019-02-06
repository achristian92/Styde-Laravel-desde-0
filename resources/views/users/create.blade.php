@extends('layout')
@section('title',"Crear Usuario")
@section('content')
    <h1>Crear Usuario</h1>

    <form action="{{route('users.store')}}" method="post">
        {!! csrf_field()!!}
        
        <button type="submit">Crear Usuario</button>

    </form>
    <p>
        <a href="{{route('users.index')}}">Regresar</a>
    </p>

@endsection
