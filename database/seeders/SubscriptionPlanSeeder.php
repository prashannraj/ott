<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Basic Plan (Free, Auto-activated)
        SubscriptionPlan::updateOrCreate(
            ['slug' => 'basic'],
            [
                'name' => 'Basic',
                'price' => 0,
                'currency' => 'NRP',
                'duration_days' => 3650, // 10 years for "auto-activated"
                'max_devices' => 1,
                'quality' => 'SD',
                'description' => 'Films, short films, documentary, reels, tv show, blogs',
                'is_active' => true,
            ]
        );

        // Premium Plan
        SubscriptionPlan::updateOrCreate(
            ['slug' => 'premium'],
            [
                'name' => 'Premium',
                'price' => 499,
                'currency' => 'NRP',
                'duration_days' => 30,
                'max_devices' => 4,
                'quality' => '4K',
                'description' => 'Premium films, premium documentary, premium tv show, newly released movies (Includes Basic features)',
                'is_active' => true,
            ]
        );
    }
}
