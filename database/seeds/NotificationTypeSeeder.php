<?php

use App\NotificationType;
use Illuminate\Database\Seeder;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notification_types')->delete();

        $data = [
            ['type' => 'text']      //picture, audio, video, events, url, subscription etc
        ];

        foreach ($data as $value) {
            NotificationType::create($value);
        }
    }
}
