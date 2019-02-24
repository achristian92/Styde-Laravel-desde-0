@extends('layout')
@section('title',"Editar Usuario")
@section('content')

    @component('shared._card')
        @slot('header')
            Editar Usuario # {{ $user->id }}
        @endslot
        @slot('content')
            @include('shared._errors')

            <form action="{{route('users.update',$user->id)}}" method="post">
                {{ method_field('PUT') }}
                @render('UserFields', ['user' => $user])
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                    <a href="{{route('users.index')}}" class="btn btn-link">Regresar</a>
                </div>
            </form>
        @endslot
    @endcomponent

@endsection
