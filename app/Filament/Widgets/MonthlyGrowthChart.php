<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Video;


class MonthlyGrowthChart extends ChartWidget
{
    

    protected function getData(): array
    {   
        // Fetch videos for the current year
        $videos = Video::whereYear('created_at', now()->year)
            ->get(['created_at'])
            ->groupBy(function($date) {
                return (int) $date->created_at->format('m');
            });

        // Initialize all months to 0
        $monthTotals = array_fill(1, 12, 0);

        // Fill in the counts
        foreach ($videos as $month => $group) {
            $monthTotals[$month] = $group->count();
        }

        return [
            //
            'labels' => [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',
            ],
            'datasets' => [
                [
                    'label' => 'Videos',
                    'data' => array_values($monthTotals),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
