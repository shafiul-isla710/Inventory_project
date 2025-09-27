<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Shafi',
                'email' => 'shafi@gmail.com',
                'role' => 'admin',
                'email_verified_at' => NULL,
                'password' => '$2y$12$a/pLP7SeOp37BxVMqPYwW.1TOsdujC7X9K8RGaZfKmqTBtCLlbEHW',
                'remember_token' => 'PapUGstAkpVSc3j52lkIKN34eMMcyuQxhIbDIzR7HjLHBez3zVOOXBGOy75z',
                'created_at' => '2025-09-27 17:13:53',
                'updated_at' => '2025-09-27 17:13:53',
            ),
        ));
        
        
    }
}