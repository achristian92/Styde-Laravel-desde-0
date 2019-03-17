<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $this->TruncateTable([
            'users',
            'user_profiles',
            'user_skill',
            'professions',
            'skills'
        ]);


        $this->call(ProfessionSeeder::class);
        $this->call(SkillSeeder::class);
        $this->call(UserSeeder::class);
    }

    public function TruncateTable(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0'); //Desactivar llaves foraneas

        foreach ($tables as $table){
            DB::table($table)->truncate(); //vaciar tabla
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // volver activar llaves
    }
}
