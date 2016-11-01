<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserSeeder::class);
        $this->call(UserGroupSeeder::class);
        $this->call(NavigationSeeder::class);
        $this->call(UserGroupToNavSeeder::class);
        $this->call(StockTransferReportSeeder::class);
        $this->call(UpdateSettingsSeeder::class);
        $this->call(UpdateNavigationAndUserGroupNavSeeder::class);

        Model::reguard();
    }
}
