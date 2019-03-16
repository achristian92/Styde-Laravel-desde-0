<?php

use App\Profession;
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

        $profeId = Profession::whereTitle('Backend')->value('id');



        $user = User::create([
            'name' => 'Alan',
            'email' => 'cristian_15@gmail.com',
            'password' => bcrypt('laravel'),
            'role' => 'admin'
        ]);

        $user->profile()->create([
            'bio' => 'Biografia desde seed',
            'profession_id' => $profeId
        ]);

        factory(User::class,100)->create()->each(function ($user){
           factory(\App\UserProfile::class)->create([
               'user_id' => $user->id,
           ]);
        });


    }
}
