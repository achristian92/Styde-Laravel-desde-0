@extends('layout')
@section('title',"Editar Usuario")
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Editar Usuario # {{ $user->id }}</h4>
        </div>
        <div class="card-body">
           @include('shared._errors')

            <form action="{{route('users.update',$user->id)}}" method="post">
                {{ method_field('PUT') }}

                @include('users._fields')
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                <a href="{{route('users.index')}}" class="btn btn-link">Regresar</a>
            </div>
            </form>
        </div>
    </div>
@endsection
