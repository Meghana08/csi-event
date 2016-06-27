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
            ['grant_type_name' => 'technical'],
            ['grant_type_name' => 'financial'],
            ['grant_type_name' => 'infrastructure']
        ];
           
        foreach ($data as $value) {
            EventGrantType::create($value);
        }
    }
}
