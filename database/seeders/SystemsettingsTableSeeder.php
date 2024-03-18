<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SystemsettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('systemsettings')->delete();
        
        \DB::table('systemsettings')->insert(array (
            0 => 
            array (
                'created_at' => '2024-03-17 20:45:08',
                'id' => 1,
                'input' => 'img/logo.png',
                'type' => 'logo',
                'updated_at' => '2024-03-17 20:45:08',
            ),
            1 => 
            array (
                'created_at' => '2024-03-17 20:47:22',
                'id' => 2,
                'input' => 'Sales and Inventory Management System',
                'type' => 'title',
                'updated_at' => '2024-03-17 20:47:22',
            ),
        ));
        
        
    }
}