<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscription;

class SubscriptionSeeder extends Seeder
{
    public function run()
    {
 
        Subscription::create([
            'name' => 'Free Plan',
            'price' => 0.00,
            'can_look_at_records' => true,
            'can_book_appointments' => true,
        ]);

        Subscription::create([
            'name' => 'Pro Plan',
            'price' => 15.00,
            'can_look_at_records' => true,
            'can_book_appointments' => true,
            'can_store_documents' => true,
            'can_make_appointments' => true,
            'can_upload_documents' => true,
        ]);

        Subscription::create([
            'name' => 'Unlimited Plan',
            'price' => 25.00,
            'can_look_at_records' => true,
            'can_book_appointments' => true,
            'can_store_documents' => true,
            'can_make_appointments' => true,
            'can_upload_documents' => true,
        ]);
    }
}
