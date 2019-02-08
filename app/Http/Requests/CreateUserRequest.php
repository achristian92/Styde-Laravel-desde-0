<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email'=> 'required|email|unique:users,email',
            'password' => 'required',
            'bio'  => 'required',
            'twitter' => 'nullable|url',
            'profession_id' => Rule::exists('professions','id')->whereNull('deleted_at')
        ];
    }

    public function messages()
    {
        return [
          'name.required' => 'campo nombre es obligatorio'
        ];
    }
    public function createUser()
    {
        $data = $this->validated();

        DB::transaction(function () use ($data){ // si algo falla a mitad de camino , no persiste en la bd
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'profession_id' => $data['profession_id'] ?? null
            ]);
            $user->profile()->create([
                'bio' => $data['bio'],
                'twitter' => $data['twitter'] ?? null,
            ]);
        });
    }
}
