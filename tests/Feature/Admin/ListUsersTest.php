<?php

namespace Tests\Feature\Admin;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListUsersTest extends TestCase
{
    use RefreshDatabase;

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
    function it_shows_the_deleted_users()
    {
        factory(User::class)->create([
            'name' => 'Alan',
            'deleted_at' => now(),
        ]);

        factory(User::class)->create([
            'name' => 'Julio',
        ]);

        $this->get('/usuarios/papelera')
            ->assertStatus(200)
            ->assertSee('Listado de usuarios en papelera')
            ->assertSee('Alan')
            ->assertDontSee('Julio');
    }

}
