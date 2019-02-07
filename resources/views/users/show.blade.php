@extends('layout')
@section('title',"Usuario {$user->id}")
@section('content')
<div class="card" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title">Usuario # {{ $user->id  }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">Detalle</h6>
        <p class="card-text">
            Nombre :{{$user->name}}
        </p>
        <div class="card-text">
            Correo : {{$user->email}}
        </div>

        <a href="{{route('users.index')}}" class="btn btn-link">Regresar</a>
    </div>
</div>

@endsection
