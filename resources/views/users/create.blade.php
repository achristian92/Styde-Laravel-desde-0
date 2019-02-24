@extends('layout')
@section('title',"Crear Usuario")
@section('content')
    @component('shared._card')
        @slot('header')
            Crear  Usuario
        @endslot
        @slot('content')
            @include('shared._errors')
            <form action="{{route('users.store')}}" method="post">
                @include('users._fields')
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Crear usuario</button>
                    <a href="{{route('users.index')}}" class="btn btn-link">Regresar</a>
                </div>
            </form>
        @endslot
    @endcomponent
@endsection
