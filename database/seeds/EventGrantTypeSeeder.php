<?php

use Illuminate\Database\Seeder;
use App\EventGrantType;

class EventGrantTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event_grant_types')->delete();
        
        $data = [
            ['grant_type_name' => 'Technical'],
            ['grant_type_name' => 'Financial'],
            ['grant_type_name' => 'Infrastructure']
        ];
           
        foreach ($data as $value) {
            EventGrantType::create($value);
        }
    }
}
