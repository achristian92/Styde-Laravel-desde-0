@extends('layout')
@section('title',"Crear Usuario")
@section('content')
    <h1>Crear nuevo Usuario</h1>

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

        <label for="name">Nombre :</label>
        <input type="text" name="name" id="name" value="{{old('name')}}">
        @if($errors->has('name'))
            <p>{{$errors->first('name')}}</p>
        @endif()
        <br>
        <label>Email</label>
        <input type="email" name="email" value="{{old('email')}}">
        <br>
        <label>Password</label>
        <input type="password" name="password">
        <br>
        <button type="submit">Crear Usuario</button>

    </form>
    <p>
        <a href="{{route('users.index')}}">Regresar</a>
    </p>

@endsection
