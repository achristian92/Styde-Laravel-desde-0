<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersModuleTest extends TestCase
{
    /** @test */
    function it_shows_the_users_list()
    {
        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('Usuarios');
    }
    /** @test */
    function it_shows_a_default_message_if_there_users_list_is_empty()
    {
        $this->get('/usuarios?empty')
            ->assertStatus(200)
            ->assertSee('No hay Usuarios Registrados');
    }

    /** @test */
    function it_loads_the_users_details_page()
    {
        $this->get('usuarios/5')
            ->assertStatus(200)
            ->assertSee('Detalle del usuario 5');
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
}
