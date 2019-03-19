<?php

use App\Profession;
use App\Skill;
use App\Team;
use App\User;
use App\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    protected $professions,$skills,$teams;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->fetchRelations();


        $user = $this->createAdmin();

        foreach (range(1,999) as $i) {
            $this->createRandomUser();
        }

    }

    /**
     * @return array
     */
    public function fetchRelations()
    {
        $this->professions = Profession::all();
        $this->skills = Skill::all();
        $this->teams = Team::all();

    }

    /**
     * @return mixed
     */
    public function createAdmin()
    {
        $admin = User::create([
            'team_id' => $this->teams->firstWhere('name', 'AlanSoft')->id,
            'name' => 'Alan',
            'email' => 'cristian_15@gmail.com',
            'password' => bcrypt('laravel'),
            'role' => 'admin',
            'created_at' => now()->addDay(),
        ]);

        $admin->skills()->attach($this->skills);

        $admin->profile()->create([
            'bio' => 'Biografia desde seed',
            'profession_id' => $this->professions->where('title', 'Desarrollador back-end')->first()->id,
        ]);
    }

    public function createRandomUser()
    {
        $user = factory(User::class)->create([
            'team_id' => rand(0, 2) ? null : $this->teams->random()->id,
        ]);

        $user->skills()->attach($this->skills->random(rand(0, 7)));

        factory(UserProfile::class)->create([
            'user_id' => $user->id,
            'profession_id' => rand(0, 2) ? $this->professions->random()->id : null,
        ]);
    }
}
