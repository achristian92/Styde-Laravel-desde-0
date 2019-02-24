{!! csrf_field()!!}
<div class="form-group">
    <label for="nombre">Nombre</label>
    <input type="text" class="form-control" id="name" name="name" value="{{old('name',$user->name)}}" />
</div>
<div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email" value="{{old('email',$user->email)}}">
</div>
<div class="form-group">
    <label for="pass">Contraseña</label>
    <input type="password" class="form-control" id="password" name="password">
</div>
<div class="form-group">
    <label for="nombre">Biografia</label>
    <textarea name="bio" class="form-control" id="bio">{{old('bio',$user->profile->bio)}}</textarea>
</div>
<div class="form-group">
    <label for="profession_id">Profession</label>
    <select class="form-control" id="profession_id" name="profession_id">
        <option value="">Seleccionar</option>
        @foreach($professions as $profession)
            <option value="{{$profession->id}}"{{old('profession_id',$user->profile->profession_id) == $profession->id ? 'selected' : ''}}>
                {{$profession->title}}
            </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="nombre">twitter</label>
    <input type="text" class="form-control" id="twitter" name="twitter" value="{{old('twitter',$user->profile->twitter)}}">
</div>
<h5>Habilidades</h5>
@foreach($skills as $index => $skill)
    <div class="form-check form-check-inline">
        <input name="skills[{{$skill->id}}]"
               class="form-check-input"
               type="checkbox"
               id="skill_{{$skill->id}}"
               value="{{$skill->id}}"
                {{$errors->any() ? old("skills.{$skill->id}") : $user->skills->contains($skill) ? 'checked' : '' }}>
        <label class="form-check-label" for="skill_{{$skill->id}}">{{$skill->name}}</label>
    </div>
@endforeach
<h5 class="mt-3">Rol</h5>
@foreach($roles as $role =>$name)
    <div class="form-check form-check-inline">
        <input class="form-check-input"
               type="radio" name="role"
               id="role_{{$role}}"
               value="{{$role}}"
                {{old('role',$user->role) == $role ? 'checked' : ''}}
        >
        <label class="form-check-label" for="role_{{$role}}">{{$role}}</label>
    </div>
@endforeach()