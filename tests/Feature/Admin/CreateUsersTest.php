<?php

namespace Tests\Feature\Admin;

use App\Profession;
use App\Skill;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUsersTest extends TestCase
{
    use RefreshDatabase;
    protected $defaultData = [
        'name' => 'Dulio',
        'email' => 'prueba@gmail.com',
        'password' => '123456',
        'bio' => 'Biografia',
        'profession_id' => '',
        'twitter' => 'https://www.facebook.com/alancristian.ruizaguirre',
        'role' => 'user'
    ];


    /** @test */
    function it_loads_the_new_users_page()
    {

        $profession = factory(Profession::class)->create();
        $skillA = factory(Skill::class)->create();
        $skillB = factory(Skill::class)->create();

        $this->get('/usuarios/nuevo')
            ->assertStatus(200)
            ->assertSee('Crear Usuario');
    }


    /** @test */
    function it_creates_a_new_user()
    {

        $profession= factory(Profession::class)->create();

        $skillsA = factory(Skill::class)->create();
        $skillsB = factory(Skill::class)->create();
        $skillsC = factory(Skill::class)->create();

        $this->post('/usuarios/store', $this->withData([
            'skills' => [$skillsA->id,$skillsB->id],
            'profession_id' => $profession->id
        ]))->assertRedirect(route('users.index'));

        $this->assertCredentials([
            'name' => 'Dulio',
            'email' => 'prueba@gmail.com',
            'password' => '123456',
            'role' => 'user'
        ]);

        $user = User::findByEmail('prueba@gmail.com');

        $this->assertDatabaseHas('user_profiles',[
            'user_id' => $user->id,
            'profession_id' => $profession->id,
            'bio' => 'Biografia',
            'twitter' => 'https://www.facebook.com/alancristian.ruizaguirre'
        ]);
        $this->assertDatabaseHas('user_skill',[
            'user_id' => $user->id,
            'skill_id' => $skillsA->id
        ]);
        $this->assertDatabaseHas('user_skill',[
            'user_id' => $user->id,
            'skill_id' => $skillsB->id
        ]);
        $this->assertDatabaseMissing('user_skill',[
            'user_id' => $user->id,
            'skill_id' => $skillsC->id
        ]);
    }


    /** @test */
    function the_twitter_field_is_optional()
    {

        $this->post('/usuarios/store',$this->withData([
            'twitter' => null
        ]))->assertRedirect(route('users.index'));

        $this->assertCredentials([ //verficar si el usuario se creo correctament con la contraseña
            'name' => 'Dulio',
            'email' => 'prueba@gmail.com',
            'password' => '123456'
        ]);
        $this->assertDatabaseHas('user_profiles',[
            'user_id' => User::findByEmail('prueba@gmail.com')->id,
            'bio' => 'Biografia',
            'twitter' => null
        ]);
    }
    /** @test */
    function the_role_field_is_optional()
    {
        $this->handleValidationExceptions();

        $this->post('/usuarios/store',$this->withData([
            'role' => null
        ]))->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users',[ //verficar si el usuario se creo correctament con la contraseña
            'email' => 'prueba@gmail.com',
            'role' => 'user'

        ]);

    }
    /** @test */
    function the_role_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->post('/usuarios/store',$this->withData([
            'role' => 'invalid-lod'
        ]))->assertSessionHasErrors('role');

        $this->assertDatabaseEmpty('users');

    }
    /** @test */
    function the_profession_id_field_is_optional()
    {
        $this->handleValidationExceptions();

        $this->post('/usuarios/store',$this->withData([
            'profession_id' => null
        ]))->assertRedirect(route('users.index'));

        $this->assertCredentials([ //verficar si el usuario se creo correctament con la contraseña
            'name' => 'Dulio',
            'email' => 'prueba@gmail.com',
            'password' => '123456',
        ]);
        $this->assertDatabaseHas('user_profiles',[
            'user_id' => User::findByEmail('prueba@gmail.com')->id,
            'profession_id' => null,
            'bio' => 'Biografia',
        ]);
    }

    /** @test */
    function the_user_is_redirected_to_the_previous_page_when_the_validation_fails()
    {
        $this->handleValidationExceptions();

        $this->from('usuarios/nuevo')
            ->post('/usuarios/store',[])
            ->assertRedirect(route('users.create'));

        $this->assertDatabaseEmpty('users');
    }
    /** @test */
    function the_name_is_required()
    {
        $this->handleValidationExceptions();

        $this->post('/usuarios/store',$this->withData([
                'name' => ''
            ]))->assertSessionHasErrors(['name' => 'campo nombre es obligatorio']);

        $this->assertDatabaseEmpty('users');
    }
    /** @test */
    function the_email_is_required()
    {
        $this->handleValidationExceptions();

        $this->post('/usuarios/store',$this->withData([
                'email' => ''
            ]))->assertSessionHasErrors(['email']);

        $this->assertDatabaseEmpty('users');
    }
    /** @test */
    function the_email_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->post('/usuarios/store',$this->withData([
                'email' => 'correo-no-valido'
            ]))->assertSessionHasErrors(['email']);

        $this->assertDatabaseEmpty('users');
    }
    /** @test */
    function the_email_must_be_unique()
    {
        $this->handleValidationExceptions();

        factory(User::class)->create([
            'email' => 'prueba@gmail.com'
        ]);

        $this->from('usuarios/nuevo')
            ->post('/usuarios/store',$this->withData([
                'email' => 'prueba@gmail.com'
            ]))

            ->assertRedirect(route('users.create'))
            ->assertSessionHasErrors(['email']);

        $this->assertEquals(1,User::count());
    }
    /** @test */
    function the_password_is_required()
    {
        $this->handleValidationExceptions();

        $this->post('/usuarios/store',$this->withData([
                'password' => ''
            ]))->assertSessionHasErrors(['password']); //error esperado es en el campo password

        $this->assertDatabaseEmpty('users');
    }
    /** @test */
    function the_profession_must_be_valid()
    {
        $this->handleValidationExceptions();


        $this->post('/usuarios/store',$this->withData([
                'profession_id' => '999'
            ]))->assertSessionHasErrors(['profession_id']); //exista un mensaje para el campo name

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function only_not_deleted_professions_can_be_selected()
    {
        $this->handleValidationExceptions();

        $deleteProfession = factory(Profession::class)->create([
            'deleted_at' => now()->format('Y-m-d')
        ]);

        $this->handleValidationExceptions();

        $this->post('/usuarios/store',$this->withData([
                'profession_id' => $deleteProfession->id
            ]))->assertSessionHasErrors(['profession_id']); //exista un mensaje para el campo name

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_skills_must_be_an_array()
    {
        $this->handleValidationExceptions();

        $this->post('/usuarios/store',$this->withData([
                'skills' => 'PHP,JS'
            ]))->assertSessionHasErrors(['skills']); //exista un mensaje para el campo name

        $this->assertDatabaseEmpty('users');
    }
    /** @test */
    function the_skills_must_be_valid()
    {
        $this->handleValidationExceptions();
        $skillA = factory(Skill::class)->create();
        $skillB = factory(Skill::class)->create();

        $this->post('/usuarios/store',$this->withData([
                'skills' => [$skillA->id,$skillB->id+1]
            ]))->assertSessionHasErrors(['skills']); //exista un mensaje para el campo name

        $this->assertDatabaseEmpty('users');
    }
}
