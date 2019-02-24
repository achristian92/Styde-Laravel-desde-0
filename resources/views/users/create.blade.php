@extends('layout')
@section('title',"Crear Usuario")
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Crear  Usuario</h4>
        </div>
        <div class="card-body">
            @include('shared._errors')
            <form action="{{route('users.store')}}" method="post">

                @include('users._fields')


                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Crear usuario</button>
                    <a href="{{route('users.index')}}" class="btn btn-link">Regresar</a>
                </div>



            </form>
        </div>
    </div>
@endsection
