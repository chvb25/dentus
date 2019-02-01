<?php

use Illuminate\Database\Seeder;

class SettingTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert(['clinic_name'=>'Nombre Clinica', 'clinic_address'=>'Dirección de la clinica', 'currency'=>'Euros', 'symbol'=>'€', 'tax'=>5]);
    }
}
