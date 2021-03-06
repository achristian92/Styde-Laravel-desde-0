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



        User::create([
            'name' => 'Alan',
            'email' => 'cristian_15@gmail.com',
            'password' => bcrypt('laravel'),
            'profession_id' => $profeId,
            'isAdmin' => true
        ]);

        factory(User::class)->create([
            'profession_id' => $profeId
        ]);

        factory(User::class,10)->create(); //10 registro aleatorios


    }
}
