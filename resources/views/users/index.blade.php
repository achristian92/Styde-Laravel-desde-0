@extends('layout')
@section('content')
    <div class="d-flex justify-content-between align-items-end">
        <h1 class="pb-1">{{ $title }}  </h1>
        <p><a href="{{route('users.create')}}" class="btn btn-primary">Nuevo Usuario</a></h3></p>
    </div>

    @if(count($users)) <!--condicional inverso(a menos que la lista usuario este vacia-->
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($users as $user)
            <tr>
                <th scope="row">{{ $user->id }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->trashed())
                        <form  action="{{route('users.destroy',$user)}}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <button type="submit" class="btn btn-link"><span class="oi oi-circle-x"></span></button>
                        </form>
                    @else
                        <form  action="{{route('users.patch',$user)}}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('patch') }}
                            <a href="{{route('users.show',$user)}}" class="btn btn-link"><span class="oi oi-eye"></span></a>
                            <a href="{{route('users.edit',$user)}}" class="btn btn-link"><span class="oi oi-eyedropper"></span></a>
                            <button type="submit" class="btn btn-link"><span class="oi oi-delete"></span></button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p>No hay Usuarios Registrados</p>
    @endif


@endsection
