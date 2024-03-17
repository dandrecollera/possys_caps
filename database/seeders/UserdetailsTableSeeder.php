<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserdetailsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('userdetails')->delete();

        \DB::table('userdetails')->insert(array (
            0 =>
            array (
                'address' => 'Test Address',
                'contact' => '12341231231',
                'created_at' => '2024-03-17 10:35:34',
                'id' => 1,
                'firstname' => 'Master',
                'lastname' => 'Admin',
                'updated_at' => '2024-03-17 10:35:34',
                'userid' => 1,
            ),
        ));


    }
}
