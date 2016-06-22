<?php

use App\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Admin::truncate();

        if( env('APP_ENV') == 'development')
        	Admin::create(['email' => 'admin@admin.com', 'name' => 'admin', 'password' => bcrypt('1234')]);

    }
}
