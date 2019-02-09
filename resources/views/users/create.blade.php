@extends('layout')
@section('title',"Crear Usuario")
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Crear nuevo Usuario</h4>
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


            <form action="{{route('users.store')}}" method="post">
                {!! csrf_field()!!}
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" />
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}">
                </div>
                <div class="form-group">
                    <label for="pass">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="form-group">
                    <label for="nombre">Biografia</label>
                    <textarea name="bio" class="form-control" id="bio">{{old('bio')}}</textarea>
                </div>
                <div class="form-group">
                    <label for="profession">Profession</label>
                    <select class="form-control" id="profession_id" name="profession_id">
                        <option value="">Seleccionar</option>
                        @foreach($professions as $profession)
                            <option value="{{$profession->id}}"{{old('$profession_id') == $profession->id ? ' selected' : ''}}>
                                {{$profession->title}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="nombre">twitter</label>
                    <input type="text" class="form-control" id="twitter" name="twitter" value="{{old('twitter')}}">
                </div>

                <button type="submit" class="btn btn-primary">Crear Usuario</button>
                <a href="{{route('users.index')}}" class="btn btn-link">Regresar</a>

            </form>
        </div>
    </div>
@endsection
