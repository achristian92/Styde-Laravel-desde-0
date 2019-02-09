<?php

use Illuminate\Database\Seeder;

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
            'professions',
            'skills'
        ]);


        $this->call(ProfessionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SkillSeeder::class);
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
