<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Subscription;

class SubscriptionRevenue extends StatsOverviewWidget
{
    

    protected function getStats(): array
    {
       $total = Subscription::count();

        $active = Subscription::where('status', 'active')
            ->where('ends_at', '>', now())
            ->count();

        $expired = Subscription::where('ends_at', '<', now())
            ->count();

        return [
            //
            Stat::make('Total Subscriptions', $total)
                ->description('All time subscriptions')
                ->color('primary'),

            Stat::make('Active Subscriptions', $active)
                ->description('Currently active')
                ->color('success'),

            Stat::make('Expired Subscriptions', $expired)
                ->description('Expired plans')
                ->color('danger'),
        ];
    }
}
