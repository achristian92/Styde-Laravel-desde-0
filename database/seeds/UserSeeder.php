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
//        $profe = DB::select('select id from professions where title = ?',['Backend']);
//        dd($profe[0]->id);
//        $profe = DB::table('professions')->select('id')->first();
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

        factory(User::class,5)->create()->each(function ($user){
            $user->profile()->create(
              factory(\App\UserProfile::class)->raw()
            );
        });


    }
}
