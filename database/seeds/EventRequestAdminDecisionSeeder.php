<?php

use Illuminate\Database\Seeder;
use App\EventRequestAdminDecision;

class EventRequestAdminDecisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('event_request_admin_decisions')->delete();
        
        $data = [
            ['decision' => 'Pending'],
            ['decision' => 'Accepted'],
            ['decision' => 'Rejected']
        ];
           
        foreach ($data as $value) {
            EventRequestAdminDecision::create($value);
        }
    }
}
