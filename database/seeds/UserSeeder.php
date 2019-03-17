<?php

use App\Profession;
use App\Skill;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $profeId = Profession::all();
        $skills = Skill::all();



        $user = User::create([
            'name' => 'Alan',
            'email' => 'cristian_15@gmail.com',
            'password' => bcrypt('laravel'),
            'role' => 'admin',
            'created_at' => now()->addDay(),
        ]);

        $user->profile()->create([
            'bio' => 'Biografia desde seed',
            'profession_id' => $profeId->where('title','Backend')->first()->id,
        ]);

        factory(User::class,100)->create()->each(function ($user) use ($profeId,$skills){
            $ramdomSkills = $skills->random(rand(0,5));
            $user->skills()->attach($ramdomSkills);
           factory(\App\UserProfile::class)->create([
               'user_id' => $user->id,
               'profession_id' => rand(0,2) ? $profeId->random()->id : null,
           ]);
        });


    }
}
