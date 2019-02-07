@extends('layout')
@section('content')
    <h1>{{ $title }}  </h1>
    <hr>
    <h3><a href="{{route('users.create')}}">Nuevo Usu</a></h3>
    @if(count($users)) <!--condicional inverso(a menos que la lista usuario este vacia-->
    <ul>
        @foreach ($users as $user)
            <li>{{ $user->name }}, ({{ $user->email }})
            <a href="{{route('users.show',$user)}}">Ver +</a> |
            <a href="{{route('users.edit',$user)}}">Edit</a> |
                <form  action="{{route('users.destroy',$user)}}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                    <button type="submit">Eliminar</button>
                </form>
        @endforeach
    </ul>
    @else
        <p>No hay Usuarios Registrados</p>
    @endif

@endsection
