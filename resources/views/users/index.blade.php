@extends('layout')
@section('content')
    <div class="d-flex justify-content-between align-items-end">
        <h1 class="pb-1">{{ $title }}  </h1>
        <p><a href="{{route('users.create')}}" class="btn btn-dark">Nuevo Usuario</a></h3></p>
    </div>
    @include('users._filters')
    @if($users->isNotEmpty()) <!--condicional inverso(a menos que la lista usuario este vacia-->
    <div class="table-responsive-lg">
        <table class="table table-sm">
            <thead class="thead-dark">
            <tr>
                <th scope="col"># <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                <th scope="col" class="sort-desc">Nombre <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                <th scope="col">Correo <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                <th scope="col">Rol <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                <th scope="col">Fechas <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                <th scope="col" class="text-right th-actions">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @each('users._row', $users, 'user')
            </tbody>
        </table>

        {{ $users->links() }}
    </div>
    @else
        <p>No hay Usuarios Registrados</p>
    @endif
@endsection

@section('sidebar')
@parent

@endsection
