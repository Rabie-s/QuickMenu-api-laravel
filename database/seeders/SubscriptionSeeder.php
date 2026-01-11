<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscriptions = [
            [
                'title' => 'Free Plan',
                'description' => '2 menu limit and contain ads.',
                'price' => 0,
                'menu_limit' => 2,
                'show_ads' => true,
                'duration_days' => null,
            ],
            [
                'title' => 'Paid Plan',
                'description' => "unlimited menus and doesn't contain ads.",
                'price' => 10,
                'menu_limit' => null, // Assuming unlimited means null
                'show_ads' => false,
                'duration_days' => 30,
            ]
        ];

        foreach ($subscriptions as $subscription) {
            Subscription::create($subscription);
        }
    }
}
