<?php

use App\Profession;
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


//        DB::table('professions')->insert([
//           'title' => 'Backend',
//        ]);

        Profession::create([
            'title' => 'Backend',
        ]);
        Profession::create([
            'title' => 'Frotend',
                ]);
        Profession::create([
            'title' => 'Diseñdor web',
                ]);
        factory(Profession::class,2)->create();

    }
}
