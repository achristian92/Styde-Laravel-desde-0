<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WelcomeUsersTest extends TestCase
{
    /** @test */
    function it_welcomes_users_with_nickname()
    {
        $this->get('saludo/alan/tavera')
        ->assertStatus(200)
        ->assertSee('Hola Alan , tu apodo es Tavera');
    }
    /** @test */
    function it_welcomes_users_without_nickname()
    {
        $this->get('saludo/alan')
            ->assertStatus(200)
            ->assertSee('Hola Alan');
    }
}
