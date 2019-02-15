<?php

namespace Tests\Browser\Admin;

use App\Profession;
use App\Skill;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateUserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_be_created()
    {
        $profession = factory(Profession::class)->create();
        $skillA = factory(Skill::class)->create();
        $skillB =factory(Skill::class)->create();

        $this->browse(function (Browser $browser) use ($profession,$skillA,$skillB){
            $browser->visit('/usuarios/nuevo')
                ->type('name','Alan')
                ->type('email','cristian_15_12_3@gmail.com')
                ->type('password','Alan')
                ->type('bio','Programador')
                ->type('twitter','http://Alan.com')
                ->select('profession_id',$profession->id)
                ->check("skills[{$skillA->id}]")
                ->check("skills[{$skillB->id}]")
                ->radio('role','user')
                ->press('Crear usuario')
                ->assertPathIs('/usuarios')
                ->assertSee('Alan')
                ->assertSee('cristian_15_12_3@gmail.com');
        });

        $this->assertCredentials([
            'name' => 'Alan',
            'email' => 'cristian_15_12_3@gmail.com',
            'password' => 'Alan',
            'role' => 'user',
        ]);
        $user = User::findByEmail('cristian_15_12_3@gmail.com');
        
        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'Programador',
            'twitter' => 'http://Alan.com',
            'user_id' => $user->id,
            'profession_id' => $profession->id,
        ]);
        $this->assertDatabaseHas('user_skill', [
            'user_id' => $user->id,
            'skill_id' => $skillA->id,
        ]);
        $this->assertDatabaseHas('user_skill', [
            'user_id' => $user->id,
            'skill_id' => $skillB->id,
        ]);



    }

}
