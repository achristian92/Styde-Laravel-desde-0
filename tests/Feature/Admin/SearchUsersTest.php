<?php

namespace Tests\Feature\Admin;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function search_users_by_name()
    {
        $alan =factory(User::class)->create([
            'name' => 'Alan',
        ]);
        $chris =factory(User::class)->create([
            'name' => 'Christian',
        ]);

        $this->get('/usuarios?search=Alan')
            ->assertStatus(200)
            ->assertViewHas('users',function ($users) use ($alan,$chris){
                return $users->contains($alan) && !$users->contains($chris);
            });
    }
    /** @test */
    function show_results_with_a_partial_search_by_name()
    {
        $alan =factory(User::class)->create([
            'name' => 'Alan',
        ]);
        $chris =factory(User::class)->create([
            'name' => 'Christian',
        ]);

        $this->get('/usuarios?search=Al')
            ->assertStatus(200)
            ->assertViewHas('users',function ($users) use ($alan,$chris){
                return $users->contains($alan) && !$users->contains($chris);
            });
    }
    /** @test */
    function search_users_by_email()
    {
        $alan =factory(User::class)->create([
            'email' => 'alancito@example.com',
        ]);
        $chris =factory(User::class)->create([
            'email' => 'papucho@gmail.com',
        ]);

        $this->get('/usuarios?search=alancito@example.com')
            ->assertStatus(200)
            ->assertViewHas('users',function ($users) use ($alan,$chris){
               return $users->contains($alan) && !$users->contains($chris);
            });
    }
    /** @test */
    function show_results_with_a_partial_search_by_email()
    {
        $alan =factory(User::class)->create([
            'email' => 'alancito@example.com',
        ]);
        $chris =factory(User::class)->create([
            'email' => 'christi@gmail.com',
        ]);

        $this->get('/usuarios?search=example.com')
            ->assertStatus(200)
            ->assertViewHas('users',function ($users) use ($alan,$chris){
                return $users->contains($alan) && !$users->contains($chris);
            });
    }
}
