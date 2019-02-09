<?php

use App\Skill;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Skill::create([
            'name' => 'HTML',
        ]);
        Skill::create([
            'name' => 'LARAVEL',
        ]);
        Skill::create([
            'name' => 'POO',
        ]);
        Skill::create([
            'name' => 'VUE.JS',
        ]);
        Skill::create([
            'name' => 'JQUERY',
        ]);

    }
}
