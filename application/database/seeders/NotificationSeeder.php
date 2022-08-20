<?php

namespace Database\Seeders;

use App\Models\Shop\Notification;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notifications = Notification::factory(1000)->create();

        foreach ($notifications as $notification) {

            if ($notification->is_read == true) {

                $notification->read_at = Carbon::parse($notification->created_at)->addHour()->format('Y-m-d');
                $notification->is_pushed = true;
                $notification->pushed_at = Carbon::parse($notification->created_at)->addHour()->format('Y-m-d');
            }

            if ($notification->is_pushed == true) {

                $notification->pushed_at = Carbon::parse($notification->created_at)->addHour()->format('Y-m-d');
            }

            $notification->notifiable_id = $notification->shop->users->random()->id;
            $notification->save();
        }
    }
}
