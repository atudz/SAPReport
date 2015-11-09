<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	DB::table('user')->insert([
    			'created_at' => new DateTime(), 
    			'user_group_id' => '1', 
    			'firstname' => 'Sfa',
    			'lastname' => 'Admin',
    			'email' => 'abnertudtud@gmail.com',
    			'password' => bcrypt('Test1234'),
    			'created_by' => '1'
    	]);
    	
    }
}
