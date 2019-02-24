<?php

namespace Tests\Feature\Admin;

use App\Profession;
use App\Skill;
use App\User;
use App\UserProfile;
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

        $oldProfession = factory(Profession::class)->create();
        $user = factory(User::class)->create();
        $user->profile()->save(factory(UserProfile::class)->make([
            'profession_id' => $oldProfession->id
        ]));
        $oldSkillA = factory(Skill::class)->create();
        $oldSkillB = factory(Skill::class)->create();

        $user->skills()->attach([$oldSkillA->id,$oldSkillB->id]);

        $newProfession = factory(Profession::class)->create();
        $newSkillA = factory(Skill::class)->create();
        $newSkillB = factory(Skill::class)->create();

        $this->put(route('users.update',$user->id),[
            'name' => 'Dulio',
            'email' => 'dulio@styde.net',
            'password' => '123456',
            'bio' => 'Biografia',
            'twitter' => 'https://www.facebook.com/alancristian.ruizaguirre',
            'role' => 'admin',
            'profession_id' => $newProfession->id,
            'skills' => [$newSkillA->id,$newSkillB->id],
        ])->assertRedirect(route('users.show',$user->id));

        $this->assertCredentials([
            'name' => 'Dulio',
            'email' => 'dulio@styde.net',
            'password' => '123456',
            'role' => 'admin'
        ]);
        $this->assertDatabaseHas('user_profiles',[
            'user_id' => $user->id,
            'bio' => 'Biografia',
            'twitter' => 'https://www.facebook.com/alancristian.ruizaguirre',
            'profession_id' => $newProfession->id,
        ]);
        $this->assertDatabaseCount('user_skill',2);
        $this->assertDatabaseHas('user_skill',[
           'user_id' => $user->id,
           'skill_id' => $newSkillA->id,
        ]);
        $this->assertDatabaseHas('user_skill',[
           'user_id' => $user->id,
           'skill_id' => $newSkillB->id,
        ]);
    }
    /** @test */
    function it_detaches_all_the_skills_if_none_is_checked()
    {

        $user = factory(User::class)->create();

        $oldSkillA = factory(Skill::class)->create();
        $oldSkillB = factory(Skill::class)->create();

        $user->skills()->attach([$oldSkillA->id,$oldSkillB->id]);


        $this->put(route('users.update',$user->id), $this->withData())
            ->assertRedirect(route('users.show',$user->id));

        $this->assertDatabaseEmpty('user_skill');

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
            ->put("/usuarios/{$user->id}", $this->withData([
                'name' => 'Alancin',
                'email' => 'pruebin@gmail.com',
                'password' => '',
            ]))->assertRedirect(route('users.show',$user->id));

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
            ->put("/usuarios/{$user->id}",$this->withData([
                'name' => 'Alancin',
                'email' => 'alan@gmail.com',
                'password' => '1235678',
            ]))->assertRedirect(route('users.show',$user->id));

        $this->assertDatabaseHas('users',[
            'name' => 'Alancin',
            'email' => 'alan@gmail.com',
        ]);
    }
    /** @test */
    function the_role_is_required()
    {
       $this->handleValidationExceptions();
       $user = factory(User::class)->create();

       $this->from("usuarios/{$user->id}/editar")
           ->put("usuarios/{$user->id}",$this->withData([
               'role' => '',
           ]))
           ->assertRedirect("usuarios/{$user->id}/editar")
           ->assertSessionHasErrors(['role']);

       $this->assertDatabaseMissing('users',['email' => 'prueba@gmail.com']);

    }



}
