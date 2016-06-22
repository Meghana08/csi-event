<?php

use Illuminate\Database\Seeder;
use App\EventGrantStatus;

class EventGrantStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event_grant_statuses')->delete();
        
        $data = [
            ['grant_status_name' => 'Waiting'],
            ['grant_status_name' => 'Accepted'],
            ['grant_status_name' => 'Negotiable'],
            ['grant_status_name' => 'Rejected'],
            ['grant_status_name' => 'Closed']
        ];
           
        foreach ($data as $value) {
            EventGrantStatus::create($value);
        }
    }
}
