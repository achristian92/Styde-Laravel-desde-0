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

        Profession::create([
            'title' => 'Backend',
        ]);
        Profession::create([
            'title' => 'Frotend',
                ]);
        Profession::create([
            'title' => 'Diseñdor web',
                ]);

    }
}
