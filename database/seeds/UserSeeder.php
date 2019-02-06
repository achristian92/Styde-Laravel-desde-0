<?php

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
        $profe = DB::table('professions')->select('id')->first();


        DB::table('users')->insert([
           'name' => 'Alan',
           'email' => 'cristian_15@gmail.com',
           'password' => bcrypt('laravel'),
           'profession_id' => $profe->id,
        ]);
    }
}
