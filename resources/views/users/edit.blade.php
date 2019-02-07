@extends('layout')
@section('title',"Editar Usuario")
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Editar Usuario # {{ $user->id }}</h4>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <p> Hay Errores!</p>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{route('users.update',$user->id)}}" method="post">
                {!! csrf_field()!!}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{old('name',$user->name)}}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{old('email',$user->email)}}">
                </div>
                <div class="form-group">
                    <label for="pass">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                <a href="{{route('users.index')}}" class="btn btn-link">Regresar</a>

            </form>
        </div>
    </div>
@endsection
