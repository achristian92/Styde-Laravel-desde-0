<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersModuleTest extends TestCase
{
    use RefreshDatabase; // ejecutar las migration de bd original

    /** @test */
    function it_shows_the_users_list()
    {
        factory(User::class)->create([
            'name' => 'Alan',
        ]);

        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('Alan')
            ->assertSee('Usuarios');
    }
    /** @test */
    function it_shows_a_default_message_if_there_users_list_is_empty()
    {
//        DB::table('users')->truncate();

        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('No hay Usuarios Registrados');
    }

    /** @test */
    function it_displays_the_users_details()
    {
        $user = factory(User::class)->create([
            'name' => 'Papuchoo'
        ]);

        $this->get('usuarios/'.$user->id)
            ->assertStatus(200)
            ->assertSee('Papuchoo');
    }
    /** @test */
    function it_loads_the_new_users_page()
    {
        $this->get('/usuarios/nuevo')
            ->assertStatus(200)
            ->assertSee('Crear nuevo Usuario');
    }
    /** @test */
    function it_loadas_the_edit_users_page()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $this->get("usuarios/{$user->id}/edit")
            ->assertStatus(200)
            ->assertSee("Editar Usuario # {$user->id}");
    }
    /** @test */
    function it_displays_a_404_error_if_the_user_is_not_found()
    {
        $this->get('/usuarios/999')
            ->assertStatus(404)
            ->assertSee('Pagina no encontrada');
    }
    /** @test */
    function it_creates_a_new_user()
    {
        //$this->withoutExceptionHandling();

        $this->post('/usuarios/store',[
           'name' => 'Dulio',
           'email' => 'prueba@gmail.com',
           'password' => '123456',
        ])->assertRedirect(route('users.index'));

        $this->assertCredentials([ //verficar si el usuario se creo correctament con la contraseña
           'name' => 'Dulio',
           'email' => 'prueba@gmail.com',
           'password' => '123456'
        ]);
    }
    /** @test */
    function the_name_is_required()
    {
//        $this->withoutExceptionHandling();

        $this->from('usuarios/nuevo')
            ->post('/usuarios/store',[
            'name' => '',
            'email' => 'prueba@gmail.com',
            'password' => '123456',
        ])->assertRedirect(route('users.create'))
          ->assertSessionHasErrors(['name' => 'campo nombre es obligatorio']); //exista un mensaje para el campo name

        $this->assertEquals(0,User::count());
        // O
        //espero que el usuario no haya sido creado ...
        $this->assertDatabaseMissing('users',[
            'email' => 'prueba@gmail.com',
        ]);
    }
    /** @test */
    function the_email_is_required()
    {
        $this->from('usuarios/nuevo')
            ->post('/usuarios/store',[
                'name' => 'Alancin',
                'email' => '',
                'password' => '123456',
            ])->assertRedirect(route('users.create'))
            ->assertSessionHasErrors(['email']);

        $this->assertEquals(0,User::count());
    }
    /** @test */
    function the_email_must_be_valid()
    {

        $this->from('usuarios/nuevo')
            ->post('/usuarios/store',[
                'name' => 'Alancin',
                'email' => 'correo-no-valido',
                'password' => '123456',
            ])->assertRedirect(route('users.create'))
            ->assertSessionHasErrors(['email']);

        $this->assertEquals(0,User::count());
    }
    /** @test */
    function the_email_must_be_unique()
    {
        factory(User::class)->create([
           'email' => 'correo_unico@gmail.com'
        ]);

        $this->from('usuarios/nuevo')
            ->post('/usuarios/store',[
                'name' => 'Alancin',
                'email' => 'correo_unico@gmail.com',
                'password' => '123456',
            ])

            ->assertRedirect(route('users.create'))
            ->assertSessionHasErrors(['email']);

        $this->assertEquals(1,User::count());
    }
    /** @test */
    function the_password_is_required()
    {
        $this->from('usuarios/nuevo')
            ->post('/usuarios/store',[
                'name' => 'Alancin',
                'email' => 'pruebin@gmail.com',
                'password' => '',
            ])->assertRedirect(route('users.create'))
            ->assertSessionHasErrors(['password']); //error esperado es en el campo password

        $this->assertEquals(0,User::count());
    }

    /** @test */
    function it_loads_the_edit_users_page()
    {
        $user = factory(User::class)->create();

        $this->get(route('users.edit',$user->id))
            ->assertViewIs('users.edit') //verificar retorne una  vista edit
            ->assertStatus(200)
            ->assertSee('Editar Usuario #')
            ->assertViewHas('user',function($viewUser) use ($user){
                return $viewUser->id == $user->id;
            }) ; //verificar q mi vista tenga una variable users y que el objeto sea userr
    }
    /** @test */
    function it_updates_a_user()
    {
        $this->withoutExceptionHandling();

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

}
