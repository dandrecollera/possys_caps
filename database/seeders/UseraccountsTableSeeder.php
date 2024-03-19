<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UseraccountsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('useraccounts')->delete();

        \DB::table('useraccounts')->insert(array (
            0 =>
            array (
                'branchid' => NULL,
                'created_at' => '2024-03-17 10:35:34',
                'id' => 1,
                'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
                'type' => 'admin',
                'updated_at' => '2024-03-17 10:35:34',
                'username' => 'admin',
                'status' => 'active',
            ),
        ));


    }
}
