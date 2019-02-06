@extends('layout')
@section('title',"Usuario {$id}")
@section('content')
    <h1>Usuario # {{ $id  }}</h1>

    Detalle del usuario {{$id}}

@endsection
