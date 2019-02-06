<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::insert('INSERT INTO professions (title) values (:TITLE)' ,[
//           'title' => 'Dessarrollo backend',
//        ]);//consulta manual de sql


        DB::table('professions')->insert([
           'title' => 'Backend',
        ]);
        DB::table('professions')->insert([
           'title' => 'Frotend',
        ]);
        DB::table('professions')->insert([
           'title' => 'Diseñdor web',
        ]);
    }
}
