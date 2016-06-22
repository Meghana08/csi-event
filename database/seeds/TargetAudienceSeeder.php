<?php

use Illuminate\Database\Seeder;
use App\TargetAudience;

class TargetAudienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('target_audience')->delete();
        
        $data = [
            ['target_name' => 'CSI Professional'],
            ['target_name' => 'CSI Student'],
            ['target_name' => 'Non CSI Member']
           
        ];
           
        foreach ($data as $value) {
            TargetAudience::create($value);
        }
    }
}
