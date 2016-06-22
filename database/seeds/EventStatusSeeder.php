<?php

use Illuminate\Database\Seeder;
use App\EventStatus;
class EventStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event_status')->delete();
        
        $data = [
            ['event_status_name' => 'Waiting'],
            ['event_status_name' => 'Accepted'],
            ['event_status_name' => 'Rejected'],
            ['event_status_name' => 'Requested For Cancellation'],
            ['event_status_name' => 'Cancelled'],
            ['event_status_name' => 'Closed']
        ];
           
        foreach ($data as $value) {
            EventStatus::create($value);
        }
    }
}
