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
        $this->get('usuarios/1/edit')
            ->assertStatus(200)
            ->assertSee('Editar el id del usu 1');
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
        $this->withoutExceptionHandling();

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
}
