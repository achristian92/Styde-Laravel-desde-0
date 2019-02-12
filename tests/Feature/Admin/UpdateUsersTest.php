<?php

namespace Tests\Feature\Admin;

use App\Profession;
use App\Skill;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateUsersTest extends TestCase
{
    use RefreshDatabase;
    protected $profession;
    protected $defaultData = [
        'name' => 'Dulio',
        'email' => 'prueba@gmail.com',
        'password' => '123456',
        'profession_id' => '',
        'bio' => 'Biografia',
        'twitter' => 'https://www.facebook.com/alancristian.ruizaguirre',
        'role' => 'user'
    ];


    /** @test */
    function it_loadas_the_edit_users_page()
    {

        $user = factory(User::class)->create();

        $this->get("usuarios/{$user->id}/edit")
            ->assertStatus(200)
            ->assertSee("Editar Usuario # {$user->id}");
    }


    /** @test */
    function it_loads_the_edit_users_page()
    {
        $this->handleValidationExceptions();

        $user = factory(User::class)->create();

        $this->get(route('users.edit',$user->id))
            ->assertViewIs('users.edit') //verificar retorne una  vista edit
            ->assertStatus(200)
            ->assertSee('Editar Usuario #')
            ->assertViewHas('user',function($viewUser) use ($user){
                return $viewUser->id == $user->id;
            }) ;
    }
    /** @test */
    function it_updates_a_user()
    {
        $this->handleValidationExceptions();

        $user = factory(User::class)->create();

        $this->put(route('users.update',$user->id),[
            'name' => 'Dulio',
            'email' => 'dulio@styde.net',
            'password' => '123456'
        ])->assertRedirect(route('users.show',$user->id));

        $this->assertCredentials([
            'name' => 'Dulio',
            'email' => 'dulio@styde.net',
            'password' => '123456'
        ]);
    }
    //TEST PARA CAMPOS OBLIGATORIOS CUANDO ACTUALICEMOS EL USUARIO

    /** @test */
    function it_name_is_required_when_updating_a_user()
    {
        $this->handleValidationExceptions();

        $user = factory(User::class)->create();

        $this->from(route('users.edit',$user->id))
            ->put(route('users.update',$user->id),[
                'name' => '',
                'email' => 'dulio@styde.net',
                'password' => '123456'
            ])
            ->assertSessionHasErrors('name')
            ->assertRedirect(route('users.edit',$user->id));

        $this->assertDatabaseMissing('users',['email' => 'dulio@styde.net']);
    }


    /** @test */
    function the_email_must_be_valid_when_updating_the_user()
    {
        $this->handleValidationExceptions();

        $user = factory(User::class)->create();

        $this->from(route('users.edit',$user->id))
            ->put(route('users.update',$user->id),[
                'name' => 'Alancin',
                'email' => 'correo-no-valido',
                'password' => '123456',
            ])->assertRedirect(route('users.edit', $user->id))
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseMissing('users',['name' => 'Alancin']);

    }
    /** @test */
    function the_email_must_be_unique_when_updating_the_user()
    {
        $this->handleValidationExceptions();

        factory(User::class)->create([
            'email' => 'existing-email@gmail.com'
        ]);

        $user = factory(User::class)->create([
            'email' => 'correo_unico@gmail.com'
        ]);

        $this->from("usuarios/{$user->id}/edit")
            ->put("/usuarios/{$user->id}",[
                'name' => 'Alancin',
                'email' => 'existing-email@gmail.com',
                'password' => '123456',
            ])

            ->assertRedirect(route('users.edit',$user->id))
            ->assertSessionHasErrors(['email']);

    }

    /** @test */
    function the_password_is_optional_when_updating_the_user()
    {
        $this->handleValidationExceptions();

        $oldPassword = 'CLAVE_ANTERIOR';

        $user = factory(User::class)->create([
            'password' => bcrypt($oldPassword)
        ]);

        $this->from("usuarios/{$user->id}/edit")
            ->put("/usuarios/{$user->id}",[
                'name' => 'Alancin',
                'email' => 'pruebin@gmail.com',
                'password' => '',
            ])->assertRedirect(route('users.show',$user->id));

        $this->assertCredentials([
            'name' => 'Alancin',
            'email' => 'pruebin@gmail.com',
            'password' => $oldPassword
        ]);
    }
    /** @test */
    function the_users_email_can_stay_the_same_when_updating_the_user()
    {
        $this->handleValidationExceptions();

        $user = factory(User::class)->create([
            'email' => 'alan@gmail.com'
        ]);

        $this->from("usuarios/{$user->id}/edit")
            ->put("/usuarios/{$user->id}",[
                'name' => 'Alancin',
                'email' => 'alan@gmail.com',
                'password' => '1235678',
            ])->assertRedirect(route('users.show',$user->id));

        $this->assertDatabaseHas('users',[
            'name' => 'Alancin',
            'email' => 'alan@gmail.com',
        ]);
    }




}
