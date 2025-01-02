<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_subscriptions')->insert([
            [
                'user_id' => 1,
                'subscription_plan_id' => 1, // Free plan
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonth(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'subscription_plan_id' => 2, // Pro plan
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonth(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'subscription_plan_id' => 3, // Unlimited plan
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addYear(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
