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