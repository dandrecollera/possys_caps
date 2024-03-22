<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BranchesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('branches')->delete();

        \DB::table('branches')->insert(array (
            0 =>
            array (
                'address' => 'Tanay',
                'created_at' => '2024-03-19 08:57:53',
                'description' => 'Main Branch on Tanay',
                'id' => 1,
                'name' => 'Main Branch',
                'status' => 'active',
                'updated_at' => '2024-03-19 08:57:53',
            ),
        ));
    }
}
