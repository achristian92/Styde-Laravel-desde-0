<?php

namespace Tests\Feature;

use App\Profession;
use App\Skill;
use App\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersModuleTest extends TestCase
{
    protected $profession;
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
        $this->withoutExceptionHandling();

        $profession = factory(Profession::class)->create();
        $skillA = factory(Skill::class)->create();
        $skillB = factory(Skill::class)->create();

        $this->get('/usuarios/nuevo')
            ->assertStatus(200)
            ->assertSee('Crear nuevo Usuario')
            ->assertViewHas('professions',function($professions) use ($profession){
                return $professions->contains($profession);
            })
            ->assertViewHas('skills' , function ($skills) use($skillA,$skillB){
                return $skills->contains($skillA) && $skills->contains($skillB);
            });
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
       // $this->withoutExceptionHandling();
        $skillsA = factory(Skill::class)->create();
        $skillsB = factory(Skill::class)->create();
        $skillsC = factory(Skill::class)->create();

        $this->post('/usuarios/store', $this->getValidData([
            'skills' => [$skillsA->id,$skillsB->id]
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
            'profession_id' => $this->profession->id,
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
        //$this->withoutExceptionHandling();

        $this->post('/usuarios/store',$this->getValidData([
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
        $this->withoutExceptionHandling();

        $this->post('/usuarios/store',$this->getValidData([
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
        //$this->withoutExceptionHandling();

        $this->post('/usuarios/store',$this->getValidData([
            'role' => 'invalid-lod'
        ]))->assertSessionHasErrors('role');

        $this->assertDatabaseEmpty('users');

    }
    /** @test */
    function the_profession_id_field_is_optional()
    {
        $this->withoutExceptionHandling();

        $this->post('/usuarios/store',$this->getValidData([
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
    function the_name_is_required()
    {
//        $this->withoutExceptionHandling();

        $this->from('usuarios/nuevo')
            ->post('/usuarios/store',$this->getValidData([
                'name' => ''
            ]))->assertRedirect(route('users.create'))
          ->assertSessionHasErrors(['name' => 'campo nombre es obligatorio']); //exista un mensaje para el campo name

        $this->assertDatabaseEmpty('users');
    }
    /** @test */
    function the_email_is_required()
    {
        $this->from('usuarios/nuevo')
            ->post('/usuarios/store',$this->getValidData([
                'email' => ''
            ]))->assertRedirect(route('users.create'))
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseEmpty('users');
    }
    /** @test */
    function the_email_must_be_valid()
    {

        $this->from('usuarios/nuevo')
            ->post('/usuarios/store',$this->getValidData([
                'email' => 'correo-no-valido'
            ]))->assertRedirect(route('users.create'))
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseEmpty('users');
    }
    /** @test */
    function the_email_must_be_unique()
    {
        factory(User::class)->create([
           'email' => 'prueba@gmail.com'
        ]);

        $this->from('usuarios/nuevo')
            ->post('/usuarios/store',$this->getValidData([
                'email' => 'prueba@gmail.com'
            ]))

            ->assertRedirect(route('users.create'))
            ->assertSessionHasErrors(['email']);

        $this->assertEquals(1,User::count());
    }
    /** @test */
    function the_password_is_required()
    {
        $this->from('usuarios/nuevo')
            ->post('/usuarios/store',$this->getValidData([
                'password' => ''
            ]))->assertRedirect(route('users.create'))
            ->assertSessionHasErrors(['password']); //error esperado es en el campo password

        $this->assertDatabaseEmpty('users');
    }
    /** @test */
    function the_profession_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->from('usuarios/nuevo')
            ->post('/usuarios/store',$this->getValidData([
                'profession_id' => '999'
            ]))->assertRedirect(route('users.create'))
            ->assertSessionHasErrors(['profession_id']); //exista un mensaje para el campo name

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function only_not_deleted_professions_can_be_selected()
    {

        $deleteProfession = factory(Profession::class)->create([
            'deleted_at' => now()->format('Y-m-d')
        ]);

        $this->handleValidationExceptions();

        $this->from('usuarios/nuevo')
            ->post('/usuarios/store',$this->getValidData([
                'profession_id' => $deleteProfession->id
            ]))->assertRedirect(route('users.create'))
            ->assertSessionHasErrors(['profession_id']); //exista un mensaje para el campo name

        $this->assertDatabaseEmpty('users');
    }
    /** @test */
    function the_skills_must_be_an_array()
    {
        $this->handleValidationExceptions();

        $this->from('usuarios/nuevo')
            ->post('/usuarios/store',$this->getValidData([
                'skills' => 'PHP,JS'
            ]))->assertRedirect(route('users.create'))
            ->assertSessionHasErrors(['skills']); //exista un mensaje para el campo name

        $this->assertDatabaseEmpty('users');
    }
    /** @test */
    function the_skills_must_be_valid()
    {
        $this->handleValidationExceptions();
        $skillA = factory(Skill::class)->create();
        $skillB = factory(Skill::class)->create();

        $this->from('usuarios/nuevo')
            ->post('/usuarios/store',$this->getValidData([
                'skills' => [$skillA->id,$skillB->id+1]
            ]))->assertRedirect(route('users.create'))
            ->assertSessionHasErrors(['skills']); //exista un mensaje para el campo name

        $this->assertDatabaseEmpty('users');
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
    //TEST PARA CAMPOS OBLIGATORIOS CUANDO ACTUALICEMOS EL USUARIO

    /** @test */
    function it_name_is_required_when_updating_a_user()
    {

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

//        $this->assertEquals(1,User::count());
    }

    /** @test */
    function the_password_is_optional_when_updating_the_user()
    {
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
    /** @test */
    function it_deletes_a_user()
    {
        $user = factory(User::class)->create();

        $this->delete(route('users.destroy',$user->id))
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseMissing('users',[
            'id' => $user->id // no espero ver
            ]);
        $this->assertSame(0,User::count());
    }


    public function getValidData(array $custom = [])
    {
        $this->profession= factory(Profession::class)->create();

        return array_merge([
            'name' => 'Dulio',
            'email' => 'prueba@gmail.com',
            'password' => '123456',
            'profession_id' => $this->profession->id,
            'bio' => 'Biografia',
            'twitter' => 'https://www.facebook.com/alancristian.ruizaguirre',
            'role' => 'user'
        ],$custom);
    }

}
