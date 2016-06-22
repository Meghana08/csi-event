<?php

use App\EventType;
use Illuminate\Database\Seeder;

class EventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event_types')->delete();
        
        $data = [
            ['event_type_name' => 'Conference'],
            ['event_type_name' => 'Seminar or Talk'],
            ['event_type_name' => 'cultural'],
            ['event_type_name' => 'Workshop or training'],
            ['event_type_name' => 'Any other...']
        ];
           
        foreach ($data as $value) {
            EventType::create($value);
        }
    }
}
