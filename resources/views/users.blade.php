<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>{{ $title }}</h1>
    <hr>
    @unless(empty($users)) <!--condicional inverso(a menos que la lista usuario este vacia-->
    <ul>
        @foreach ($users as $user)
            <li>{{ $user }}</li>
        @endforeach
    </ul>
    @else
        <p>No hay Usuarios Registrados</p>
    @endunless

</body>
</html>